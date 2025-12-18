<?php namespace App\Controllers;
use App\Models\JadwalModel;

class ApiSync extends BaseController {
    // contoh penggunaan: curl http://host/api/sync
    public function sync() {
        $jadwalModel = new JadwalModel();

        // konfigurasi lokasi bisa disimpan dalam table pengaturan; untuk ringkas kita set jakarta
        $lat = '-6.914744'; $lng = '107.609810'; // contoh Bandung
        $month = date('m'); $year = date('Y');

        // gunakan API aladhan.com untuk list by month (lebih stabil)
        $url = "http://api.aladhan.com/v1/calendar?latitude={$lat}&longitude={$lng}&method=2&month={$month}&year={$year}";

        $opts = stream_context_create(['http'=>['timeout'=>10]]);
        $json = @file_get_contents($url, false, $opts);
        if(!$json) {
            return $this->response->setStatusCode(500)->setJSON(['status'=>'error','msg'=>'API unreachable']);
        }
        $data = json_decode($json, true);
        if(!isset($data['data'])) {
            return $this->response->setStatusCode(500)->setJSON(['status'=>'error','msg'=>'invalid response']);
        }

        foreach($data['data'] as $day) {
            $date = date('Y-m-d', strtotime($day['date']['gregorian']['date']));
            $timings = $day['timings'];
            // normalisasi: ambil H:i:s
            $row = [
                'tanggal' => $date,
                'subuh' => date('H:i:s', strtotime($timings['Fajr'])),
                'imsak' => date('H:i:s', strtotime($timings['Imsak'])),
                'dzuhur' => date('H:i:s', strtotime($timings['Dhuhr'])),
                'ashar' => date('H:i:s', strtotime($timings['Asr'])),
                'maghrib' => date('H:i:s', strtotime($timings['Maghrib'])),
                'isya' => date('H:i:s', strtotime($timings['Isha'])),
                'source' => 'aladhan'
            ];
            $exists = $jadwalModel->where('tanggal',$date)->first();
            if($exists) {
                $jadwalModel->update($exists['id'],$row);
            } else {
                $jadwalModel->insert($row);
            }
        }

        return $this->response->setJSON(['status'=>'ok','msg'=>'sync done']);
    }
}
