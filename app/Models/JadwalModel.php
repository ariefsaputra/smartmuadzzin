<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $endpoint = 'https://api.myquran.com/v2/sholat/jadwal';

    public function getTodaySchedule($kota_id)
    {
        $today = date('Y-m-d');
        $url = "{$this->endpoint}/{$kota_id}/{$today}";

        $client = \Config\Services::curlrequest();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        return $data['data']['jadwal'] ?? [];
    }
}
