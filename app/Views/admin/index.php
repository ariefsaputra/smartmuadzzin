<!-- app/Views/admin/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="bg-gray-100 p-4" x-data="{ tab: 'info' }">

    <div class="max-w-5xl mx-auto bg-white p-4 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Halaman Admin</h1>

        <!-- Tabs -->
        <div class="flex border-b mb-4">
            <button @click="tab = 'info'" :class="tab === 'info' ? 'border-b-2 border-blue-500 text-blue-500' : ''" class="px-4 py-2">Informasi Masjid</button>
            <button @click="tab = 'running'" :class="tab === 'running' ? 'border-b-2 border-blue-500 text-blue-500' : ''" class="px-4 py-2">Update Running Text</button>
            <button @click="tab = 'slider'" :class="tab === 'slider' ? 'border-b-2 border-blue-500 text-blue-500' : ''" class="px-4 py-2">Manage Slider Image</button>
        </div>

        <!-- Tab: Informasi Masjid -->
        <div x-show="tab === 'info'">
            <form action="<?= base_url('admin/save-info') ?>" method="POST" class="space-y-4">
                <div>
                    <label class="block mb-1 font-semibold">Nama Masjid</label>
                    <input type="text" name="nama_masjid" value="<?= esc($pengaturan['nama_masjid'] ?? '') ?>" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Alamat Masjid</label>
                    <textarea name="alamat_masjid" class="w-full border rounded p-2"><?= esc($pengaturan['alamat_masjid'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">ID Kota Masjid</label>
                    <select id="id_kota" name="id_kota" class="w-full border rounded p-2"></select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>

        <!-- Tab: Running Text -->
        <div x-show="tab === 'running'">
            <form action="<?= base_url('admin/save-running-text') ?>" method="POST">
                <label class="block mb-1 font-semibold">Running Text (pisahkan kalimat dengan tanda ;)</label>
                <textarea name="running_text" rows="4" class="w-full border rounded p-2"><?= esc($pengaturan['running_text'] ?? '') ?></textarea>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>

        <!-- Tab: Slider Image -->
        <div x-show="tab === 'slider'">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">Daftar Slider</h2>
                <form action="<?= base_url('admin/slider/add') ?>" method="POST" enctype="multipart/form-data">
                    <input type="file" name="gambar" required>
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Tambah</button>
                </form>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <?php foreach ($sliders as $slider): ?>
                    <div class="border rounded overflow-hidden">
                        <img src="<?= base_url('uploads/slider/' . $slider['gambar']) ?>" class="w-full h-32 object-cover">
                        <form action="<?= base_url('admin/slider/delete/' . $slider['id']) ?>" method="POST" class="p-2 text-center">
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#id_kota').select2({
                placeholder: 'Pilih Kota',
                ajax: {
                    url: 'https://api.myquran.com/v2/sholat/kota/semua',
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: data.map(function(kota) {
                                return {
                                    id: kota.id,
                                    text: kota.lokasi
                                };
                            })
                        };
                    }
                }
            });

            // Set value jika sudah ada
            let selectedId = "<?= esc($pengaturan['id_kota'] ?? '') ?>";
            let selectedText = "<?= esc($pengaturan['nama_kota'] ?? '') ?>";
            if (selectedId && selectedText) {
                let option = new Option(selectedText, selectedId, true, true);
                $('#id_kota').append(option).trigger('change');
            }
        });
    </script>

</body>

</html>