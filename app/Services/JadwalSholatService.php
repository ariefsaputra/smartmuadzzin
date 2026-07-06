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

        //set timezone ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        $today = date('Y-m-d');
        $todayJadwal = date('d-m-Y');

        // check di DB apakah jadwal hari ini sudah ada dan sumbernya dari API
        $jadwal = $jadwalModel->where('tanggal', $today)->first();

        if (!$jadwal) {
            // Ambil Jadwal dari API untuk hari ini
            $url = "https://api.myquran.com/v3/sholat/jadwal/fc221309746013ac554571fbd180e1c8/today?tz=Asia%2FJakarta";

            $apiResponse = file_get_contents($url);
            $jadwal = json_decode($apiResponse, true);
            
            if(isset($jadwal['data']['jadwal'][$today])) {
                // jika data jadwal hari ini ada di API, simpan ke database
                $urlHijri = "https://api.myquran.com/v3/cal/today?adj=0&tz=Asia%2FJakarta";
                $hijriResponse = file_get_contents($urlHijri);
                $hijriData = json_decode($hijriResponse, true);

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
