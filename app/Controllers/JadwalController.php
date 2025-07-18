<?php

namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\JadwalSholatModel;

class JadwalController extends BaseController
{
    protected $apiBase = 'https://api.myquran.com/v2/sholat/jadwal';

    public function syncHarian()
    {
        $tanggal = date('Y/m/d');
        return $this->syncPerHari($tanggal);
    }

    public function syncBulanan()
    {
        $bulan = date('Y/m');
        return $this->syncPerBulan($bulan);
    }

    public function syncTahunan()
    {
        $tahun = date('Y');
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $month = sprintf('%s-%02d', $tahun, $bulan);
            $this->syncPerBulan($month, false); // silent
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Sinkronisasi tahunan berhasil.'
        ]);
    }

    private function syncPerHari(string $tanggal)
    {
        $idKota = $this->getIdKota();
        if (!$idKota) {
            return $this->fail('ID Kota belum disetel.');
        }

        $url = "{$this->apiBase}/{$idKota}/{$tanggal}";
        $data = $this->fetchApi($url);

        if (!isset($data['jadwal'])) {
            return $this->fail("Gagal mengambil data untuk tanggal $tanggal.");
        }

        $this->saveScheduleData([$data['jadwal']], true); // simpan sebagai array
        return $this->success("Sinkronisasi berhasil untuk tanggal $tanggal.");
    }

    private function syncPerBulan(string $bulan, bool $withResponse = true)
    {
        $idKota = $this->getIdKota();
        if (!$idKota) {
            return $withResponse ? $this->fail('ID Kota belum disetel.') : false;
        }

        $url = "{$this->apiBase}/{$idKota}/{$bulan}";
        $result = $this->fetchApi($url);
        if (!$result || !isset($result['jadwal'])) {
            return $withResponse ? $this->fail("Gagal mengambil data bulan $bulan.") : false;
        }

        $this->saveScheduleData($result['jadwal'], true);

        if ($withResponse) {
            return $this->success("Sinkronisasi bulan $bulan berhasil.");
        }

        return true;
    }

    private function saveScheduleData(array $jadwalList, bool $clearExisting = false)
    {
        $model = new JadwalSholatModel();

        if ($clearExisting && count($jadwalList) > 0) {
            $first  = date('Y-m-d', strtotime($jadwalList[0]['tanggal']));
            $last   = date('Y-m-d', strtotime(end($jadwalList)['tanggal']));
            $model->where('tanggal >=', $first)->where('tanggal <=', $last)->delete();
        }

        foreach ($jadwalList as $row) {
            $tanggal = date('Y-m-d', strtotime($row['date']));

            $urlCal = "https://api.myquran.com/v2/cal/hijr/{$tanggal}";
            $dataHijri = $this->fetchApi($urlCal);

            if (!$dataHijri) {
                return $this->fail("Gagal mengambil data untuk tanggal $tanggal.");
            }

            $hijri = $dataHijri['date'][1];

            $model->save([
                'tanggal'          => $tanggal,
                'tanggal_hijriyah' => $hijri,
                'imsak'            => $row['imsak'],
                'subuh'            => $row['subuh'],
                'syuruq'           => $row['terbit'],
                'dhuha'            => $row['dhuha'],
                'dzuhur'           => $row['dzuhur'],
                'ashar'            => $row['ashar'],
                'maghrib'          => $row['maghrib'],
                'isya'             => $row['isya']
            ]);
        }
    }


    private function fetchApi(string $url): ?array
    {
        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($url);
            $result = json_decode($response->getBody(), true);
            return $result['data'] ?? null;
        } catch (\Throwable $e) {
            log_message('error', 'Gagal fetch API: ' . $e->getMessage());
            return null;
        }
    }

    private function getIdKota(): ?string
    {
        $pengaturan = new PengaturanModel();
        return $pengaturan->get('id_kota');
    }

    private function success(string $message)
    {
        return $this->response->setJSON(['status' => true, 'message' => $message]);
    }

    private function fail(string $message)
    {
        return $this->response->setJSON(['status' => false, 'message' => $message]);
    }
}
