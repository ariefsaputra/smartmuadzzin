<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-xl shadow-sm border max-w-2xl">

    <h3 class="text-xl font-semibold mb-6">Pengaturan Masjid</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-3 mb-4 bg-green-100 text-green-700 rounded-lg">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/pengaturan/save') ?>">
        <?= csrf_field() ?>

        <!-- Nama Masjid -->
        <div class="mb-4">
            <label class="text-sm text-gray-600">Nama Masjid</label>
            <input
                type="text"
                name="nama_masjid"
                value="<?= $data['nama_masjid'] ?? '' ?>"
                class="w-full p-2 mt-1 border rounded-lg"
                required>
        </div>

        <!-- Alamat Masjid -->
        <div class="mb-4">
            <label class="text-sm text-gray-600">Alamat Masjid</label>
            <textarea
                name="alamat_masjid"
                class="w-full p-2 mt-1 border rounded-lg"
                rows="2"><?= $data['alamat_masjid'] ?? '' ?></textarea>
        </div>

        <div class="mb-4">
            <label for="kodeKota" class="text-sm text-gray-600">Kode Kota MyQuran</label>
            <input id="kodeKota" name="kode_kota" type="text" inputmode="numeric" pattern="[0-9]+"
                value="<?= esc($data['kode_kota'] ?? '') ?>"
                class="w-full p-2 mt-1 border rounded-lg" required>
            <p class="mt-1 text-xs text-gray-500">Masukkan ID kota dari MyQuran. Nilai ini tetap dapat diubah tanpa koneksi internet.</p>
        </div>

        <div class="mb-4">
            <label for="namaKota" class="text-sm text-gray-600">Nama Kota</label>
            <input id="namaKota" name="nama_kota" type="text"
                value="<?= esc($data['nama_kota'] ?? '') ?>"
                class="w-full p-2 mt-1 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-600">Running Text</label>
            <textarea name="running_text" class="w-full p-2 mt-1 border rounded-lg" rows="2">
                <?= $data['running_text'] ?? '' ?>
            </textarea>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Durasi Menjelang Adzan (detik)</label>
            <input type="number" class="form-control"
                name="durasi_menjelang_adzan"
                value="<?= $pengaturan['durasi_menjelang_adzan'] ?? 600 ?>">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Durasi Adzan (detik)</label>
            <input type="number" class="form-control"
                name="durasi_adzan"
                value="<?= $pengaturan['durasi_adzan'] ?? 240 ?>">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Durasi Menjelang Iqamah (detik)</label>
            <input type="number" class="form-control"
                name="durasi_menjelang_iqamah"
                value="<?= $pengaturan['durasi_menjelang_iqamah'] ?? 300 ?>">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Durasi Waktu Sholat (detik)</label>
            <input type="number" class="form-control"
                name="durasi_waktu_sholat"
                value="<?= $pengaturan['durasi_waktu_sholat'] ?? 600 ?>">
        </div>

        <div class="mb-4">
            <label class="font-semibold">Durasi Khutbah Jumat (detik)</label>
            <input type="number" class="form-control"
                name="durasi_khutbah_jumat"
                value="<?= $pengaturan['durasi_khutbah_jumat'] ?? 1200 ?>">
        </div>


        <button class="mt-5 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Simpan Pengaturan
        </button>

    </form>
</div>

<?= $this->endSection() ?>
