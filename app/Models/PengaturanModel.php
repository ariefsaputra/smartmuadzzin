<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'keyname';
    protected $allowedFields = [
        'value',
        'created_at',
        'updated_at',
    ];
}
