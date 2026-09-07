<?php namespace App\Controllers;
use App\Services\JadwalSholatService;
use Config\SyncAuth as SyncAuthConfig;

class ApiSync extends BaseController {
    // Example: curl -X POST -H "X-Sync-Token: <token>" https://host/api/sync
    public function sync() {
        $config = config(SyncAuthConfig::class);
        $token = (string) $this->request->getHeaderLine('X-Sync-Token');

        if ($config->token === '' || ! hash_equals($config->token, $token)) {
            return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'msg' => 'Forbidden']);
        }

        $settings = db_connect()->table('pengaturan')->get()->getResultArray();
        $pengaturan = [];
        foreach ($settings as $setting) {
            $pengaturan[$setting['keyname']] = $setting['value'];
        }

        $kodeKota = trim((string) ($pengaturan['kode_kota'] ?? ''));
        if ($kodeKota === '') {
            return $this->response->setStatusCode(422)->setJSON(['status' => 'error', 'msg' => 'Kode kota belum dikonfigurasi.']);
        }

        $schedule = (new JadwalSholatService())->getTodayPrayer($kodeKota, true);
        if ($schedule === null) {
            return $this->response->setStatusCode(502)->setJSON(['status' => 'error', 'msg' => 'API MyQuran tidak dapat dihubungi.']);
        }

        return $this->response->setJSON(['status' => 'ok', 'msg' => 'sync done', 'source' => 'myquran']);
    }
}
