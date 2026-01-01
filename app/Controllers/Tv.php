<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\MediaModel;
use App\Models\PengumumanModel;

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


        /* ==========================
         * 5. Kirim ke View
         * ========================== */
        return view('tv_main', [
            'data' => [
                'nama_masjid'   => $nama_masjid,
                'alamat_masjid' => $alamat_masjid,
            ],
            'jadwal'       => $jadwal,
            'medias'       => $medias,
            'pengumuman'   => $pengumuman,
            'running_text' => $running_text
        ]);
    }
}
