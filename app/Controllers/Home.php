<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;
use App\Models\JadwalSholatModel;

class Home extends BaseController
{
    protected $pengaturanModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
        $this->jadwalModel     = new JadwalSholatModel();
    }

    public function index()
    {
        // Ambil seluruh pengaturan sekali panggil
        $pengaturan = $this->pengaturanModel->getAllAsKeyValue();

        // Ambil jadwal dari DB lokal
        $jadwal = $this->jadwalModel->getTodaySchedule();

        // Siapkan fallback default
        $data = [
            'pengaturan' => $pengaturan,
            'jadwal' => $jadwal
        ];

        return view('display/index', $data);
    }
}
