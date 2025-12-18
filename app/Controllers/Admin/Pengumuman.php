<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;

class Pengumuman extends BaseController
{
    public function index()
    {
        $model = new PengumumanModel();
        $data['rows'] = $model->orderBy('id', 'desc')->findAll();

        return view('admin/pengumuman/index', $data);
    }

    public function create()
    {
        return view('admin/pengumuman/create');
    }

    public function store()
    {
        $model = new PengumumanModel();

        $model->insert([
            'judul'    => $this->request->getPost('judul'),
            'isi'      => $this->request->getPost('isi'),
            'kategori' => $this->request->getPost('kategori'),
            'mulai'    => $this->request->getPost('mulai'),
            'sampai'   => $this->request->getPost('sampai'),
            'durasi'   => $this->request->getPost('durasi'),
            'enabled'  => $this->request->getPost('enabled') ? 1 : 0
        ]);

        return redirect()->to('/admin/pengumuman')->with('success', 'Pengumuman disimpan.');
    }

    public function edit($id)
    {
        $model = new PengumumanModel();
        $data['row'] = $model->find($id);
        return view('admin/pengumuman/edit', $data);
    }

    public function update($id)
    {
        $model = new PengumumanModel();

        $model->update($id, [
            'judul'    => $this->request->getPost('judul'),
            'isi'      => $this->request->getPost('isi'),
            'kategori' => $this->request->getPost('kategori'),
            'mulai'    => $this->request->getPost('mulai'),
            'sampai'   => $this->request->getPost('sampai'),
            'durasi'   => $this->request->getPost('durasi'),
            'enabled'  => $this->request->getPost('enabled') ? 1 : 0
        ]);

        return redirect()->to('/admin/pengumuman')->with('success', 'Pengumuman diupdate.');
    }

    public function delete($id)
    {
        (new PengumumanModel())->delete($id);
        return redirect()->to('/admin/pengumuman')->with('success', 'Pengumuman dihapus.');
    }
}
