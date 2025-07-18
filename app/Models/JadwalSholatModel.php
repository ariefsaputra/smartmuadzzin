<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalSholatModel extends Model
{
    protected $table            = 'jadwal_sholat';
    protected $primaryKey       = 'tanggal';
    protected $allowedFields = [
        'tanggal', 'tanggal_hijriyah', 'imsak', 'subuh', 'syuruq', 'dhuha',
        'dzuhur', 'ashar', 'maghrib', 'isya'
    ];

    protected $useTimestamps        = false;
    protected $useAutoIncrement     = false;
    protected $returnType           = 'array';

    /**
     * Ambil jadwal sholat untuk hari ini (berdasarkan tanggal server)
     */
    public function getTodaySchedule(): ?array
    {
        $today = date('Y-m-d');
        return $this->find($today); // Karena primaryKey = tanggal
    }

    /**
     * Ambil jadwal sholat untuk tanggal tertentu (YYYY-MM-DD)
     */
    public function getScheduleByDate(string $tanggal): ?array
    {
        return $this->find($tanggal);
    }

    /**
     * Ambil jadwal sholat untuk rentang tanggal
     */
    public function getScheduleRange(string $start, string $end): array
    {
        return $this->where('tanggal >=', $start)
                    ->where('tanggal <=', $end)
                    ->orderBy('tanggal', 'asc')
                    ->findAll();
    }
}
