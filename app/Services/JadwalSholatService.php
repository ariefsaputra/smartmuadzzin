<?php

namespace App\Services;

use App\Models\JadwalModel;
use Config\Services;
use Throwable;

class JadwalSholatService
{
    /**
     * Uses the local record whenever it is available. If the provider fails,
     * the existing local schedule is returned so the TV stays usable offline.
     */
    public function getTodayPrayer(?string $kodeKota, bool $forceRefresh = false): ?array
    {
        //set TIMEZONE
        date_default_timezone_set('Asia/Jakarta');
        
        $model = new JadwalModel();
        $today = date('Y-m-d');
        $existing = $model->where('tanggal', $today)->first();

        if ($existing !== null && ! $forceRefresh) {
            return $existing;
        }

        $kodeKota = trim((string) $kodeKota);
        if ($kodeKota === '') {
            log_message('warning', 'Prayer schedule refresh skipped: no city code configured.');
            return $existing;
        }

        try {
            // Hapus seluruh data sebelum tanggal hari ini
            $model->where('tanggal <', $today)->delete();

            $response = Services::curlrequest([
                'timeout'         => 10,
                'connect_timeout' => 5,
                'http_errors'     => false,
            ])->get(sprintf(
                'https://api.myquran.com/v3/sholat/jadwal/%s/today?tz=Asia%%2FJakarta',
                rawurlencode($kodeKota)
            ));

            if ($response->getStatusCode() !== 200) {
                throw new \RuntimeException('Prayer API returned HTTP ' . $response->getStatusCode());
            }

            $payload = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $days = $payload['data']['jadwal'] ?? [];

            // result array(1) { ["2026-09-07"]=> array(9) { ["tanggal"]=> string(17) "Senin, 07/09/2026" ["imsak"]=> string(5) "04:22" ["subuh"]=> string(5) "04:32" ["terbit"]=> string(5) "05:40" ["dhuha"]=> string(5) "06:12" ["dzuhur"]=> string(5) "11:51" ["ashar"]=> string(5) "15:08" ["maghrib"]=> string(5) "17:55" ["isya"]=> string(5) "19:00" } }
            // ambil berdasarkan result
            $day = $days[$today] ?? null;
            
            if (! is_array($day)) {
                throw new \RuntimeException('Prayer API did not include today\'s schedule.');
            }

            $schedule = [
                'tanggal'  => $today,
                'hijriyah' => $this->getHijriDate($today) ?? ($existing['hijriyah'] ?? null),
                'imsak'    => $day['imsak'],
                'subuh'    => $day['subuh'] ?? null,
                'syuruq'   => $day['terbit'] ?? null,
                'dhuha'    => $day['dhuha'] ?? null,
                'dzuhur'   => $day['dzuhur'] ?? null,
                'ashar'    => $day['ashar'] ?? null,
                'maghrib'  => $day['maghrib'] ?? null,
                'isya'     => $day['isya'] ?? null,
                'source'   => 'myquran',
            ];

            if ($existing !== null) {
                $model->update($existing['id'], $schedule);
            } else {
                $model->insert($schedule);
            }

            return $schedule;
        } catch (Throwable $exception) {
            log_message('warning', 'Prayer schedule refresh failed: {message}', ['message' => $exception->getMessage()]);
            return $existing;
        }
    }

    public function getJadwalToday(?string $idKota): ?array
    {
        return $this->getTodayPrayer($idKota);
    }

    private function getHijriDate(string $date): ?string
    {
        try {
            $response = Services::curlrequest([
                'timeout' => 10,
                'connect_timeout' => 5,
                'http_errors' => false,
            ])->get('https://api.myquran.com/v3/cal/today?adj=0&tz=Asia%2FJakarta');

            $payload = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            $hijriDay = $payload['data']['hijr']['day'] ?? null;
            $hijriMonthName = $payload['data']['hijr']['monthName'] ?? null;
            $hijriYear = $payload['data']['hijr']['year'] ?? null;
            $hijriDate = $hijriDay && $hijriMonthName && $hijriYear ? "{$hijriDay} {$hijriMonthName} {$hijriYear} H" : null;

            return ($payload['status'] ?? false) === true ? $hijriDate : null;
        } catch (Throwable $exception) {
            log_message('warning', 'Hijri calendar refresh failed: {message}', ['message' => $exception->getMessage()]);
            return null;
        }
    }
    
}
