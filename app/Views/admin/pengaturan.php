<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- LOAD SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="bg-white p-6 rounded-xl shadow-sm border max-w-2xl">

    <h3 class="text-xl font-semibold mb-6">Pengaturan Masjid</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="p-3 mb-4 bg-green-100 text-green-700 rounded-lg">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/pengaturan/save') ?>">

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

        <!-- PILIH KOTA SELECT2 -->
        <div class="mb-4">
            <label class="text-sm text-gray-600">Kota</label>
            <select id="selectKota" class="w-full p-2 border rounded-lg">
                <?php if (isset($data['kode_kota'])): ?>
                    <option value="<?= $data['kode_kota'] ?>" selected><?= $data['nama_kota'] ?></option>
                <?php endif; ?>
            </select>
        </div>

        <!-- Hidden field untuk disimpan -->
        <input type="hidden" id="kodeKota" name="kode_kota" value="<?= $data['kode_kota'] ?? '' ?>">
        <input type="hidden" id="namaKota" name="nama_kota" value="<?= $data['nama_kota'] ?? '' ?>">

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

<!-- INIT SELECT2 + LOAD DATA API -->
<script>
    $(document).ready(function() {
        $('#selectKota').select2({
            placeholder: "Ketik nama kota...",
            allowClear: true,
            ajax: {
                url: "https://api.myquran.com/v2/sholat/kota/semua",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {

                    const items = data.data.map(item => ({
                        id: item.id,
                        text: item.lokasi
                    }));

                    return {
                        results: items
                    };
                },
                cache: true
            }
        });

        // Simpan nilai setelah dipilih
        $('#selectKota').on('select2:select', function(e) {
            let id = e.params.data.id;
            let text = e.params.data.text;

            $('#kodeKota').val(id);
            $('#namaKota').val(text);
        });
    });
</script>

<?= $this->endSection() ?>