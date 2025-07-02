<?php namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'kunci';
    protected $allowedFields = ['kunci', 'nilai'];
    public $timestamps = false;

    public function get($kunci)
    {
        return $this->where('kunci', $kunci)->first()['nilai'] ?? null;
    }

    public function getMany(array $keys)
    {
        $result = $this->whereIn('kunci', $keys)->findAll();
        $assoc = [];
        foreach ($result as $row) {
            $assoc[$row['kunci']] = $row['nilai'];
        }
        return $assoc;
    }
}
