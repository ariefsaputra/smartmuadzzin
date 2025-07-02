<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;
use App\Models\JadwalModel;

class Home extends BaseController
{
    public function index()
    {
        $pengaturanModel = new PengaturanModel();
        $jadwalModel     = new JadwalModel();

        // Ambil data pengaturan
        $pengaturan = $pengaturanModel->first();

        // Ambil kota_id dan nama masjid dari pengaturan
        $kota_id      = $pengaturanModel->get('id_kota')      ?? '1219'; // fallback: Bandung
        $nama_masjid  = $pengaturanModel->get('nama_masjid')  ?? 'Nama Masjid';
        $running_text = $pengaturanModel->get('running_text') ?? 'Selamat datang di Masjid kami.';

        // Ambil jadwal sholat dari API
        $jadwal = $jadwalModel->getTodaySchedule($kota_id);

        return view('display/index', [
            'pengaturan'   => [
                'kota_id'      => $kota_id,
                'nama_masjid'  => $nama_masjid,
                'running_text' => $running_text,
            ],
            'jadwal' => $jadwal
        ]);
    }
}
