<?php

namespace App\Controllers;

use Config\AdminAuth as AdminAuthConfig;

class AdminAuth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_authenticated') === true) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/login');
    }

    public function authenticate()
    {
        $config = config(AdminAuthConfig::class);
        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        if ($config->username === '' || $config->passwordHash === '') {
            log_message('critical', 'Admin credentials have not been configured.');
            return redirect()->back()->with('error', 'Kredensial admin belum dikonfigurasi.');
        }

        if (! hash_equals($config->username, $username) || ! password_verify($password, $config->passwordHash)) {
            return redirect()->back()->with('error', 'Username atau password tidak valid.');
        }

        session()->regenerate();
        session()->set('admin_authenticated', true);

        return redirect()->to(site_url('admin'));
    }

    public function logout()
    {
        session()->remove('admin_authenticated');
        session()->regenerate();

        return redirect()->to(site_url('admin/login'));
    }
}
