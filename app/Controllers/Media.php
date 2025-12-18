<?php

namespace App\Controllers;

use App\Models\MediaModel;

class Media extends BaseController
{
    public function index()
    {
        $model = new MediaModel();
        $data['media'] = $model->orderBy('ordering', 'ASC')->findAll();

        return view('admin/media/index', $data);
    }

    public function create()
    {
        return view('admin/media/create');
    }

    public function store()
    {
        $file = $this->request->getFile('file');

        // Validasi dasar
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Upload tidak valid.');
        }

        // Dapatkan nama baru yang aman
        $newName = $file->getRandomName();

        // Pindahkan file ke writable/uploads
        $file->move(FCPATH . 'writable/uploads', $newName);

        // Dapatkan tipe MIME dari client (aman)
        $mime = $file->getClientMimeType();
        $type = (strpos($mime, 'video') !== false) ? 'video' : 'image';

        // Simpan ke database
        $model = new MediaModel();
        $model->insert([
            'filename' => $newName,
            'type'     => $type,
            'title'    => $this->request->getPost('title'),
            'enabled'  => 1,
            'ordering' => time(),
            'duration' => $this->request->getPost('duration') ?? 6000
        ]);

        return redirect()->to('/admin/media')->with('success', 'Media berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $model = new MediaModel();
        $data['m'] = $model->find($id);

        return view('admin/media/edit', $data);
    }

    public function update($id)
    {
        $model = new MediaModel();

        $model->update($id, [
            'title'    => $this->request->getPost('title'),
            'enabled'  => $this->request->getPost('enabled'),
            'duration' => $this->request->getPost('duration'),
        ]);

        return redirect()->to('/admin/media');
    }

    public function delete($id)
    {
        $model = new MediaModel();
        $data = $model->find($id);

        if ($data) unlink('writable/uploads/' . $data['filename']);

        $model->delete($id);

        return redirect()->to('/admin/media');
    }

    // Drag & Drop reorder
    public function reorder()
    {
        $model = new MediaModel();
        $items = $this->request->getPost('order');

        $i = 1;
        foreach ($items as $id) {
            $model->update($id, ['ordering' => $i++]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }
}
