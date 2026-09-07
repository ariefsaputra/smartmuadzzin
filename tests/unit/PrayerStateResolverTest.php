<?php

namespace Tests\Unit;

use App\Services\PrayerStateResolver;
use CodeIgniter\Test\CIUnitTestCase;
use DateTimeImmutable;
use DateTimeZone;

final class PrayerStateResolverTest extends CIUnitTestCase
{
    private PrayerStateResolver $resolver;

    /** @var array{pre:int, adzan:int, iqamah:int, prayer:int, khutbahJumat:int} */
    private array $durations = ['pre' => 600, 'adzan' => 240, 'iqamah' => 300, 'prayer' => 600, 'khutbahJumat' => 1200];

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new PrayerStateResolver();
    }

    public function testItResolvesAllRegularPrayerStates(): void
    {
        $times = ['subuh' => '05:00'];

        $this->assertSame('menjelang_adzan', $this->stateAt('2026-09-07 04:55:00', $times));
        $this->assertSame('adzan', $this->stateAt('2026-09-07 05:01:00', $times));
        $this->assertSame('menjelang_iqamah', $this->stateAt('2026-09-07 05:05:00', $times));
        $this->assertSame('waktu_sholat', $this->stateAt('2026-09-07 05:10:00', $times));
    }

    public function testItResolvesAllFridayStates(): void
    {
        $times = ['dzuhur' => '12:00'];

        $this->assertSame('jumat_pre', $this->stateAt('2026-09-11 11:55:00', $times));
        $this->assertSame('jumat_adzan', $this->stateAt('2026-09-11 12:01:00', $times));
        $this->assertSame('jumat_khutbah', $this->stateAt('2026-09-11 12:05:00', $times));
        $this->assertSame('jumat_sholat', $this->stateAt('2026-09-11 12:25:00', $times));
    }

    public function testItReturnsNullOutsidePrayerWindowsAndForInvalidTimes(): void
    {
        $this->assertNull($this->resolver->resolve($this->now('2026-09-07 03:00:00'), ['subuh' => '05:00'], $this->durations));
        $this->assertNull($this->resolver->resolve($this->now('2026-09-07 04:55:00'), ['subuh' => '--:--'], $this->durations));
    }

    /** @param array<string, string> $times */
    private function stateAt(string $time, array $times): ?string
    {
        return $this->resolver->resolve($this->now($time), $times, $this->durations)['state'] ?? null;
    }

    private function now(string $time): DateTimeImmutable
    {
        return new DateTimeImmutable($time, new DateTimeZone('Asia/Jakarta'));
    }
}
