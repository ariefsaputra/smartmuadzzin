<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\MediaModel;
use App\Models\PengumumanModel;
use App\Services\JadwalSholatService;

class Tv extends BaseController
{
    public function index()
    {
        $db = db_connect();

        /* ==========================
         * 1. Ambil Pengaturan
         * ========================== */
        $q = $db->table('pengaturan')->get()->getResultArray();
        $pengaturan = [];
        foreach ($q as $row) {
            $pengaturan[$row['keyname']] = $row['value'];
        }
        
        if (($pengaturan['mode'] ?? 'online') === 'online') {
            // Refresh when the configured city changes; otherwise preserve the
            // local record when the remote provider is unavailable.
            $jadwalService = new JadwalSholatService();
            $kodeKota = trim((string) ($pengaturan['kode_kota'] ?? ''));
            $forceRefresh = $kodeKota !== '' && ($pengaturan['jadwal_kode_kota'] ?? '') !== $kodeKota;
            $syncedSchedule = $jadwalService->getTodayPrayer($kodeKota, $forceRefresh);

            if ($syncedSchedule !== null && $forceRefresh) {
                $db->table('pengaturan')->replace([
                    'keyname' => 'jadwal_kode_kota',
                    'value'   => $kodeKota,
                ]);
            }
        }

        $nama_masjid   = $pengaturan['nama_masjid']   ?? 'MASJID';
        $alamat_masjid = $pengaturan['alamat_masjid'] ?? '';
        $kode_kota     = $pengaturan['kode_kota']     ?? '';
        $running_text  = $pengaturan['running_text']  ?? '';

        /* ==========================
         * 2. Ambil Jadwal Sholat Hari Ini
         * ========================== */
        $tanggalHariIni = date('Y-m-d');
            $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel->where('tanggal', $tanggalHariIni)->first();
        // fallback jika tidak ada jadwal
        if (!$jadwal) {

            $jadwal = [
                'imsak' => '--:--',
                'subuh' => '--:--',
                'syuruq' => '--:--',
                'dhuha' => '--:--',
                'dzuhur' => '--:--',
                'ashar' => '--:--',
                'maghrib' => '--:--',
                'isya'  => '--:--',
            ];
        }

        /* ==========================
         * 3. Media Slider
         * ========================== */
        $mediaModel = new MediaModel();
        $medias = $mediaModel->where('enabled', 1)->orderBy('ordering', 'ASC')->findAll();

        /* ==========================
         * 4. Pengumuman
         * ========================== */
        $pengumumanModel = new PengumumanModel();

        $pengumuman = $pengumumanModel
            ->where('enabled', 1)
            ->where('mulai <=', date('Y-m-d H:i:s'))
            ->where('sampai >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'desc')
            ->findAll();


        $prayerTimes = [
            ['name' => 'Imsak', 'time' => $jadwal['imsak'], 'icon' => 'imsak.png', 'color' => 'text-indigo-500'],
            ['name' => 'Subuh', 'time' => $jadwal['subuh'], 'icon' => 'shubuh.png', 'color' => 'text-amber-500'],
            ['name' => 'Syuruq', 'time' => $jadwal['syuruq'], 'icon' => 'syuruq.png', 'color' => 'text-yellow-500'],
            ['name' => 'Dhuha', 'time' => $jadwal['dhuha'], 'icon' => 'dhuha.png', 'color' => 'text-orange-500'],
            ['name' => 'Dzuhur', 'time' => $jadwal['dzuhur'], 'icon' => 'dzuhur.png', 'color' => 'text-amber-600'],
            ['name' => 'Ashar', 'time' => $jadwal['ashar'], 'icon' => 'ashar.png', 'color' => 'text-orange-600'],
            ['name' => 'Maghrib', 'time' => $jadwal['maghrib'], 'icon' => 'maghrib.png', 'color' => 'text-rose-500'],
            ['name' => 'Isya', 'time' => $jadwal['isya'], 'icon' => 'isya.png', 'color' => 'text-indigo-600'],
        ];

        $slides = array_map(static function (array $media): array {
            return [
                'url' => base_url('writable/uploads/' . $media['filename']),
                'type' => $media['type'],
                'title' => $media['filename'],
                'duration' => (int) ($media['duration'] ?: 5000),
            ];
        }, $medias);

        /* ==========================
         * 5. Kirim ke View
         * ========================== */
        return view('tv/layout', [
            'data' => [
                'nama_masjid'   => $nama_masjid,
                'alamat_masjid' => $alamat_masjid,
            ],
            'jadwal'       => $jadwal,
            'medias'       => $medias,
            'pengumuman'   => $pengumuman,
            'running_text' => $running_text,
            'pengaturan'   => $pengaturan,
            'mosque'       => ['name' => $nama_masjid, 'address' => $alamat_masjid],
            'prayerTimes'  => $prayerTimes,
            'slides'       => $slides,
            'dateMasehi'   => date('d F Y'),
            'dayName'      => [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ][date('l')] ?? date('l'),
            'dateHijriyah' => $jadwal['hijriyah'] ?? '',
        ]);
    }
}
