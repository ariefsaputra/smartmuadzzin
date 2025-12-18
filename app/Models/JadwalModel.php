<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal_sholat';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tanggal',
        'hijriyah',
        'imsak',
        'subuh',
        'syuruq',
        'dhuha',
        'dzuhur',
        'ashar',
        'maghrib',
        'isya',
        'source'
    ];
    protected $returnType = 'array';
}
