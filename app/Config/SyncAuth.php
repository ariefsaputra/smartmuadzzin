<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class SyncAuth extends BaseConfig
{
    public string $token;

    public function __construct()
    {
        parent::__construct();
        $this->token = (string) env('sync.token', '');
    }
}
