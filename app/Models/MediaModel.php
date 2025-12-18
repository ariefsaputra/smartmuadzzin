<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media_slider';

    protected $allowedFields = [
        'filename',
        'type',
        'title',
        'enabled',
        'ordering',
        'duration'
    ];
}
