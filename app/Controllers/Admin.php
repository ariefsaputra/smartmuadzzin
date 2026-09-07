<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\MediaModel;
use App\Models\PengumumanModel;
use App\Models\PengaturanModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $jadwalModel = new JadwalModel();
        $mediaModel  = new MediaModel();
        $pengModel   = new PengumumanModel();
        $pengaturanModel = new PengaturanModel();

        // mode online/offline ambil dari pengaturan
        $pengaturan = $pengaturanModel->findAll();
        $pengaturanData = [];
        foreach ($pengaturan as $p) {
            $pengaturanData[$p['keyname']] = $p['value'];
        }

        $currentMode = strtolower($pengaturanData['mode'] ?? 'online');

        $today = date('Y-m-d');

        // Jadwal hari ini
        $jadwal = $jadwalModel->where('tanggal', $today)->first();

        // Semua media slider
        $medias = $mediaModel->findAll();

        // Semua pengumuman
        $pengumuman = $pengModel->orderBy('created_at', 'DESC')->findAll();

        // --- STATUS DATA JADWAL (Up to date / Outdated) ---
        $lastJadwal = $jadwalModel->orderBy('tanggal', 'DESC')->first();

        if ($lastJadwal && $lastJadwal['tanggal'] >= $today) {
            $apiStatusView = [
                'ok'            => true,
                'status'        => 'Up to date',
                'tanggal_data'  => $lastJadwal['tanggal'],
            ];
        } else {
            $apiStatusView = [
                'ok'            => false,
                'status'        => 'Outdated / Perlu update',
                'tanggal_data'  => $lastJadwal['tanggal'] ?? '-',
            ];
        }

        // Kirim semua data ke view
        echo view('admin/dashboard', [
            'jadwal'        => $jadwal,
            'medias'        => $medias,
            'pengumuman'    => $pengumuman,
            'apiStatusView' => $apiStatusView,
            'pengaturan'    => $pengaturanData
        ]);
    }

    public function changeMode($newMode = null)
    {
        $pengaturanModel = new PengaturanModel();
        $currentMode = $pengaturanModel->where('keyname', 'mode')->first();
        $newMode = strtolower($newMode);

        if (!in_array($newMode, ['online', 'offline'])) {
            return redirect()->back()->with('error', "Mode tidak valid: {$newMode}");
        }

        // update mode in database
        if ($currentMode) {
            $pengaturanModel->update('mode', ['value' => $newMode]);
        } else {
            $pengaturanModel->insert(['keyname' => 'mode', 'value' => $newMode]);
        }

        return redirect()->back()->with('success', "Mode berhasil diubah menjadi: {$newMode}");
    }

    // upload media simple handler (POST file)
    public function media()
    {
        $mediaModel = new MediaModel();
        $request = service('request');
        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('file');
            if ($file && $file->isValid()) {
                $newName = date('YmdHis') . '_' . str_replace(' ', '_', $file->getName());
                $file->move(WRITEPATH . 'uploads', $newName);
                $type = strpos($file->getClientMimeType(), 'video') !== false ? 'video' : 'image';
                $mediaModel->insert([
                    'filename' => $newName,
                    'type' => $type,
                    'caption' => $this->request->getPost('caption'),
                    'ordering' => (int)$this->request->getPost('ordering', 0),
                    'enabled' => 1
                ]);
                return redirect()->to('/admin')->with('success', 'Upload berhasil');
            }
        }
        echo view('admin/media_form');
    }

    public function jadwal()
    {
        $db = db_connect();
        $rows = $db->table('pengaturan')->get()->getResultArray();

        $peng = [];
        foreach ($rows as $r) $peng[$r['keyname']] = $r['value'];

        return view('admin/jadwal_sync', [
            'active'     => 'jadwal',
            'title'      => 'Sinkronisasi Jadwal Sholat',
            'header'     => 'Sync Jadwal Sholat Bulanan',
            'kode_kota'  => $peng['kode_kota'] ?? '',
            'nama_kota'  => $peng['nama_kota'] ?? ''
        ]);
    }


    public function syncJadwal()
    {
        // HEADER UNTUK SSE
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("Connection: keep-alive");

        // MATIKAN SEMUA OUTPUT BUFFERING
        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        $jadwalModel = new \App\Models\JadwalModel();
        $req = service('request');

        // ambil kode kota dari pengaturan
        $db = db_connect();
        $rows = $db->table('pengaturan')->get()->getResultArray();
        $peng = [];
        foreach ($rows as $r) $peng[$r['keyname']] = $r['value'];

        $kode_kota = $peng['kode_kota'] ?? null;

        $bulan = $req->getPost('bulan');
        $tahun = $req->getPost('tahun');

        if (!$kode_kota || !$bulan || !$tahun) {
            echo "data: " . json_encode(['error' => "Parameter tidak lengkap"]) . "\n\n";
            flush();
            exit;
        }

        $url = "https://api.myquran.com/v2/sholat/jadwal/{$kode_kota}/{$tahun}/{$bulan}";
        $json = @file_get_contents($url);

        if (!$json) {
            echo "data: " . json_encode(['error' => "API tidak dapat dihubungi"]) . "\n\n";
            flush();
            exit;
        }

        $data = json_decode($json, true);

        if (!isset($data['data']['jadwal'])) {
            echo "data: " . json_encode(['error' => "Format data API salah"]) . "\n\n";
            flush();
            exit;
        }

        $list = $data['data']['jadwal'];
        $total = count($list);
        $saved = 0;

        foreach ($list as $row) {

            $tanggal = $row['date'];

            // Hijriyah is fetched only for the current display day by
            // JadwalSholatService. Avoid one remote request for every day.
            $exists = $jadwalModel->where('tanggal', $tanggal)->first();

            $save = [
                'tanggal' => $tanggal,
                'hijriyah' => $exists['hijriyah'] ?? null,
                'imsak'   => $row['imsak'] . ":00",
                'subuh'   => $row['subuh'] . ":00",
                'syuruq'  => $row['terbit'] . ":00",
                'dhuha'   => $row['dhuha'] . ":00",
                'dzuhur'  => $row['dzuhur'] . ":00",
                'ashar'   => $row['ashar'] . ":00",
                'maghrib' => $row['maghrib'] . ":00",
                'isya'    => $row['isya'] . ":00",
                'source'  => 'myquran'
            ];

            if ($exists) $jadwalModel->update($exists['id'], $save);
            else $jadwalModel->insert($save);

            // SSE progress
            $saved++;
            echo "data: " . json_encode([
                'progress' => $saved,
                'total'    => $total
            ]) . "\n\n";

            flush();
        }


        exit;
    }

    public function checkApi()
    {
        $rows = db_connect()->table('pengaturan')->get()->getResultArray();
        $pengaturan = [];
        foreach ($rows as $row) {
            $pengaturan[$row['keyname']] = $row['value'];
        }

        $kodeKota = trim((string) ($pengaturan['kode_kota'] ?? ''));
        if ($kodeKota === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'msg' => 'Kode kota belum dikonfigurasi.'
            ]);
        }

        $url = sprintf(
            'https://api.myquran.com/v2/sholat/jadwal/%s/%s/%s',
            rawurlencode($kodeKota),
            date('Y'),
            date('m')
        );

        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $res = @file_get_contents($url, false, $ctx);

        if (!$res) {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'API MyQuran tidak dapat dihubungi.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ok',
            'msg' => 'API dapat diakses.'
        ]);
    }

    public function pengaturan()
    {
        $db = db_connect();
        $q = $db->table('pengaturan')->get()->getResultArray();

        $pengaturan = [];
        foreach ($q as $row) {
            $pengaturan[$row['keyname']] = $row['value'];
        }

        return view('admin/pengaturan', [
            'active' => 'pengaturan',
            'title'  => 'Pengaturan Masjid',
            'header' => 'Pengaturan Sistem',
            'data'   => $pengaturan,
            'pengaturan' => $pengaturan,
        ]);
    }

    public function savePengaturan()
    {
        $db = db_connect();
        $table = $db->table('pengaturan');

        $items = [
            'nama_masjid'  => $this->request->getPost('nama_masjid'),
            'alamat_masjid' => $this->request->getPost('alamat_masjid'),
            'kode_kota'    => $this->request->getPost('kode_kota'),
            'nama_kota'    => $this->request->getPost('nama_kota'),
            'running_text' => $this->request->getPost('running_text'),
            'durasi_menjelang_adzan'  => $this->request->getPost('durasi_menjelang_adzan'),
            'durasi_adzan'            => $this->request->getPost('durasi_adzan'),
            'durasi_menjelang_iqamah' => $this->request->getPost('durasi_menjelang_iqamah'),
            'durasi_waktu_sholat'     => $this->request->getPost('durasi_waktu_sholat'),
            'durasi_khutbah_jumat'    => $this->request->getPost('durasi_khutbah_jumat'),
        ];

        // simpan satu per satu
        foreach ($items as $key => $val) {
            $exists = $table->where('keyname', $key)->get()->getRow();
            if ($exists) {
                $table->where('keyname', $key)->update(['value' => $val]);
            } else {
                $table->insert(['keyname' => $key, 'value' => $val]);
            }
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
