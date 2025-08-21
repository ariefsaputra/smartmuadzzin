<?php

namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\SliderModel;

class AdminController extends BaseController
{
    protected $pengaturanModel;
    
    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index()
    {
        $pengaturan = (new PengaturanModel())->getAllAsKeyValue();
        $slider = (new SliderModel())->findAll();

        return view('admin/index', [
            'pengaturan' => $pengaturan,
            'sliders' => $slider
        ]);
    }

    public function savePengaturan()
    {
        $data = [
            'nama_masjid'    => $this->request->getPost('nama_masjid'),
            'alamat_masjid'  => $this->request->getPost('alamat_masjid'),
            'id_kota'        => $this->request->getPost('id_kota'),
            'running_text'   => $this->request->getPost('running_text'),
        ];

        foreach ($data as $kunci => $nilai) {
            $this->pengaturanModel->saveOrUpdate($kunci, $nilai);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Pengaturan berhasil disimpan.'
        ]);
    }

    public function saveRunningText()
    {
        $runningText = $this->request->getPost('running_text');
        (new PengaturanModel())->update(1, [
            'running_text' => $runningText
        ]);
        return redirect()->back()->with('success', 'Running text diperbarui.');
    }

    public function uploadSlider()
    {
        $file = $this->request->getFile('slider_image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/slider', $newName);

            (new SliderModel())->insert([
                'filename' => $newName
            ]);
        }
        return redirect()->back()->with('success', 'Gambar slider ditambahkan.');
    }

    public function deleteSlider($id)
    {
        $sliderModel = new SliderModel();
        $slider = $sliderModel->find($id);
        if ($slider) {
            @unlink(FCPATH . 'uploads/slider/' . $slider['filename']);
            $sliderModel->delete($id);
        }
        return redirect()->back()->with('success', 'Gambar slider dihapus.');
    }
}
