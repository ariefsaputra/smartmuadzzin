<?php

namespace App\Services;
use Config\Services;
use App\Models\JadwalModel;

class ApiService
{
    // API Jadwal Sholat Hari Ini
    public function getTodayPrayer()
    {
        $url = "https://api.myquran.com/v3/sholat/jadwal/" . $kode_kota . "/today?tz=Asia%2FJakarta";
        $apiResponse = file_get_contents($url);
        $jadwal = json_decode($apiResponse, true);

        return $jadwal;
    }

    // API Calendar Hijri
    public function getTodayHijri()
    {
        $url = "https://api.myquran.com/v3/cal/today?adj=0&tz=Asia%2FJakarta";
        $apiResponse = file_get_contents($url);
        $hijriData = json_decode($apiResponse, true);

        if ($hijriData['status'] === true) {
            $hijriah = $hijriData['data']['hijr']['day'] . ' ' .
                $hijriData['data']['hijr']['monthName'] . ' ' .
                $hijriData['data']['hijr']['year'] . ' H';

            return $hijriah;
        } else {
            return null; // atau bisa lempar exception
        }
    }

    // API Semua Kota
    public function getAllCities($find = null)
    {
        $url = "https://api.myquran.com/v3/sholat/kota/find/" . $find;
        $apiResponse = file_get_contents($url);
        $citiesData = json_decode($apiResponse, true);

        return $citiesData;
    }
}