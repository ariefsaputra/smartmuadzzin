<?php
namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_masjid','alamat_masjid','kode_kota','running_text',
        'menjelang_adzan',
        'iqamah_subuh','iqamah_dzuhur','iqamah_ashar','iqamah_maghrib','iqamah_isya'
    ];
}
