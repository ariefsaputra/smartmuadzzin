<?php

namespace App\Services;

use Config\Services;
use App\Models\JadwalModel;

class JadwalSholatService
{
    //Ambil Jadwal hari ini dari API Aladhan
    public function getTodayPrayer()
    {
        $jadwalModel = new JadwalModel();

        $today = date('Y-m-d');
        $todayJadwal = date('d-m-Y');

        // check di DB apakah jadwal hari ini sudah ada dan sumbernya dari API
        $jadwal = $jadwalModel->where('tanggal', $today)->first();

        if (!$jadwal) {
            // Ambil Jadwal dari API untuk hari ini
            $url = "https://api.myquran.com/v3/sholat/jadwal/fc221309746013ac554571fbd180e1c8/today?tz=Asia%2FJakarta";
            
            /** OUTPUT API
             * {"status":true,"message":"success","data":{"id":"fc221309746013ac554571fbd180e1c8","kabko":"KOTA BANDUNG","prov":"JAWA BARAT","jadwal":{"2026-06-22":{"tanggal":"Senin, 22/06/2026","imsak":"04:29","subuh":"04:39","terbit":"05:52","dhuha":"06:26","dzuhur":"11:55","ashar":"15:15","maghrib":"17:51","isya":"19:01"}}}}
             */

            $apiResponse = file_get_contents($url);
            $jadwal = json_decode($apiResponse, true);

            if(isset($jadwal['data']['jadwal'][$today])) {
                // jika data jadwal hari ini ada di API, simpan ke database
                $urlHijri = "https://api.myquran.com/v3/cal/today?adj=0&tz=Asia%2FJakarta";
                $hijriResponse = file_get_contents($urlHijri);
                $hijriData = json_decode($hijriResponse, true);

                /**
                 * OUTPUT API Hijri
                 * {"status":true,"message":"success","data":{"method":"standar","adjustment":0,"ce":{"today":"Senin, 22 Juni 2026","day":22,"dayName":"Senin","month":6,"monthName":"Juni","year":2026},"hijr":{"today":"Senin, 7 Muharam 1448 H","day":7,"dayName":"Senin","month":1,"monthName":"Muharam","year":1448}}}
                 */

                $hijriah = $hijriData['data']['hijr']['day'] . ' ' .
                    $hijriData['data']['hijr']['monthName'] . ' ' .
                    $hijriData['data']['hijr']['year'] . ' H';

                $jadwalHariIni = [
                    'tanggal' => $today,
                    'hijriyah' => $hijriah,
                    'imsak'   => $jadwal['data']['jadwal'][$today]['imsak'] . ":00",
                    'subuh'   => $jadwal['data']['jadwal'][$today]['subuh'] . ":00",
                    'syuruq'  => $jadwal['data']['jadwal'][$today]['terbit'] . ":00",
                    'dhuha'   => $jadwal['data']['jadwal'][$today]['dhuha'] . ":00",
                    'dzuhur'  => $jadwal['data']['jadwal'][$today]['dzuhur'] . ":00",
                    'ashar'   => $jadwal['data']['jadwal'][$today]['ashar'] . ":00",
                    'maghrib' => $jadwal['data']['jadwal'][$today]['maghrib'] . ":00",
                    'isya'    => $jadwal['data']['jadwal'][$today]['isya'] . ":00",
                    'source'  => 'myquran'
                ];

                // simpan ke database
                $jadwalModel->insert($jadwalHariIni);

                //return data jadwal hari ini
                return $jadwalHariIni;
            } else {
                // jika tidak ada data jadwal hari ini di API, return null
                return null;
            }
                
        }
    }


    public function getJadwalToday($idKota = null)
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
