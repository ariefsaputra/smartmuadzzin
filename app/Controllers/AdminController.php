<?php

namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\SliderModel;

class AdminController extends BaseController
{
    public function index()
    {
        $pengaturan = (new PengaturanModel())->first();
        $slider = (new SliderModel())->findAll();

        return view('admin/index', [
            'pengaturan' => $pengaturan,
            'sliders' => $slider
        ]);
    }

    public function saveMasjid()
    {
        $data = $this->request->getPost();
        (new PengaturanModel())->update(1, [
            'nama_masjid' => $data['nama_masjid'],
            'alamat_masjid' => $data['alamat_masjid'],
            'id_kota' => $data['id_kota']
        ]);
        return redirect()->back()->with('success', 'Informasi masjid diperbarui.');
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
