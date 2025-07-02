<?php namespace App\Services;

use Config\Services;

class JadwalSholatService
{
    public function getJadwalToday($idKota)
    {
        $tanggal = date('Y/m/d');
        $url = "https://api.myquran.com/v2/sholat/jadwal/$idKota/$tanggal";

        $client = Services::curlrequest();
        $response = $client->get($url);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $data = json_decode($response->getBody(), true);

        // Pastikan struktur respons cocok
        if (isset($data['data']['jadwal'])) {
            return $data['data']['jadwal'];
        }

        return null;
    }
}
