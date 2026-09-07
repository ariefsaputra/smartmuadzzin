<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/** Credentials are supplied only through .env, never the database or source. */
class AdminAuth extends BaseConfig
{
    public string $username;
    public string $passwordHash;

    public function __construct()
    {
        parent::__construct();

        $this->username     = (string) env('admin.username', '');
        $this->passwordHash = password_hash((string) env('admin.password', ''), PASSWORD_DEFAULT);
        // $this->passwordHash = (string) env('admin.password', '');
    }
}
