<?php namespace App\Models;

use CodeIgniter\Model;

class PosterModel extends Model
{
    protected $table = 'posters';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'gambar', 'aktif'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $useSoftDeletes = false;

    public function getAktif()
    {
        return $this->where('aktif', 1)->findAll();
    }
}
