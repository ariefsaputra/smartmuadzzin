<?php

namespace App\Services;

use DateTimeImmutable;

final class PrayerStateResolver
{
    /**
     * @param array<string, string> $prayerTimes
     * @param array{pre:int, adzan:int, iqamah:int, prayer:int, khutbahJumat:int} $durations
     * @return array{state:string, prayer:string, countdown:int}|null
     */
    public function resolve(DateTimeImmutable $now, array $prayerTimes, array $durations): ?array
    {
        if ((int) $now->format('N') === 5) {
            $jumat = $this->resolveFriday($now, $prayerTimes['dzuhur'] ?? '', $durations);
            if ($jumat !== null) {
                return $jumat;
            }
        }

        foreach (['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $prayer) {
            if ((int) $now->format('N') === 5 && $prayer === 'dzuhur') {
                continue;
            }

            $state = $this->resolveRegular($now, $prayer, $prayerTimes[$prayer] ?? '', $durations);
            if ($state !== null) {
                return $state;
            }
        }

        return null;
    }

    /**
     * @param array{pre:int, adzan:int, iqamah:int, prayer:int, khutbahJumat:int} $durations
     * @return array{state:string, prayer:string, countdown:int}|null
     */
    private function resolveRegular(DateTimeImmutable $now, string $prayer, string $time, array $durations): ?array
    {
        $diff = $this->secondsUntil($now, $time);
        if ($diff === null) {
            return null;
        }

        if ($diff > 0 && $diff <= $durations['pre']) {
            return ['state' => 'menjelang_adzan', 'prayer' => strtoupper($prayer), 'countdown' => $diff];
        }
        if ($diff <= 0 && $diff > -$durations['adzan']) {
            return ['state' => 'adzan', 'prayer' => strtoupper($prayer), 'countdown' => $durations['adzan'] + $diff];
        }
        if ($diff <= -$durations['adzan'] && $diff > -($durations['adzan'] + $durations['iqamah'])) {
            return ['state' => 'menjelang_iqamah', 'prayer' => strtoupper($prayer), 'countdown' => $durations['adzan'] + $durations['iqamah'] + $diff];
        }
        if ($diff <= -($durations['adzan'] + $durations['iqamah']) && $diff > -($durations['adzan'] + $durations['iqamah'] + $durations['prayer'])) {
            return ['state' => 'waktu_sholat', 'prayer' => strtoupper($prayer), 'countdown' => 0];
        }

        return null;
    }

    /**
     * @param array{pre:int, adzan:int, iqamah:int, prayer:int, khutbahJumat:int} $durations
     * @return array{state:string, prayer:string, countdown:int}|null
     */
    private function resolveFriday(DateTimeImmutable $now, string $time, array $durations): ?array
    {
        $diff = $this->secondsUntil($now, $time);
        if ($diff === null) {
            return null;
        }

        if ($diff > 0 && $diff <= $durations['pre']) {
            return ['state' => 'jumat_pre', 'prayer' => 'JUMAT', 'countdown' => $diff];
        }
        if ($diff <= 0 && $diff > -$durations['adzan']) {
            return ['state' => 'jumat_adzan', 'prayer' => 'JUMAT', 'countdown' => $durations['adzan'] + $diff];
        }
        if ($diff <= -$durations['adzan'] && $diff > -($durations['adzan'] + $durations['khutbahJumat'])) {
            return ['state' => 'jumat_khutbah', 'prayer' => 'JUMAT', 'countdown' => 0];
        }
        if ($diff <= -($durations['adzan'] + $durations['khutbahJumat']) && $diff > -($durations['adzan'] + $durations['khutbahJumat'] + $durations['prayer'])) {
            return ['state' => 'jumat_sholat', 'prayer' => 'JUMAT', 'countdown' => 0];
        }

        return null;
    }

    private function secondsUntil(DateTimeImmutable $now, string $time): ?int
    {
        if (!preg_match('/^(\d{1,2}):(\d{2})(?::\d{2})?$/', trim($time), $matches)) {
            return null;
        }

        $target = $now->setTime((int) $matches[1], (int) $matches[2], 0);

        return $target->getTimestamp() - $now->getTimestamp();
    }
}
