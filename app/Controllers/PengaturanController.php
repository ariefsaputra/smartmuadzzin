<?php

namespace App\Controllers;

use App\Models\PengaturanModel;

class PengaturanController extends BaseController
{
    public function load()
    {
        $model = new PengaturanModel();
        $rows = $model->findAll();

        $data = [];
        foreach ($rows as $row) {
            $data[$row['kunci']] = $row['nilai'];
        }

        return $this->response->setJSON(['status' => true, 'data' => $data]);
    }

    public function save()
    {
        $model = new PengaturanModel();
        $request = $this->request->getJSON(true); // menerima JSON body

        foreach ($request as $kunci => $nilai) {
            $model->save([
                'kunci' => $kunci,
                'nilai' => $nilai
            ]);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Pengaturan berhasil disimpan']);
    }
}
