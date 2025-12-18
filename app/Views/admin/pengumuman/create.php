<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="container mx-auto px-6 py-6" x-data="pengumumanForm()">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tambah Pengumuman</h1>

        <a href="<?= base_url('/admin/pengumuman') ?>"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            Kembali
        </a>
    </div>

    <form action="<?= base_url('/admin/pengumuman/store') ?>" method="post"
        class="bg-white rounded-lg shadow-lg p-6 space-y-6">

        <!-- JUDUL -->
        <div>
            <label class="font-semibold">Judul Pengumuman</label>
            <input type="text" name="judul"
                class="w-full mt-1 px-3 py-2 border rounded-lg"
                required>
        </div>

        <!-- KATEGORI -->
        <div>
            <label class="font-semibold">Kategori</label>
            <select name="kategori" id="kategori" x-model="kategori" @change="applyTemplate()"
                class="w-full mt-1 px-3 py-2 border rounded-lg" required>

                <option value="" selected disabled>-- Pilih Kategori Terlebih Dahulu --</option>
                <option value="keuangan_jumat">Laporan Keuangan per Jumat</option>
                <option value="imam_khatib">Imam / Khatib Jumat</option>
                <option value="umum">Umum</option>

            </select>
        </div>

        <!-- ISI -->
        <div>
            <label class="font-semibold">Isi Pengumuman</label>
            <textarea name="isi" rows="6" id="isiField"
                class="w-full mt-1 px-3 py-2 border rounded-lg"></textarea>
        </div>

        <!-- TANGGAL MULAI -->
        <div>
            <label class="font-semibold">Mulai Tampil</label>
            <input type="datetime-local" name="mulai"
                class="w-full mt-1 px-3 py-2 border rounded-lg"
                required>
        </div>

        <!-- TANGGAL SAMPAI -->
        <div>
            <label class="font-semibold">Sampai Tanggal</label>
            <input type="datetime-local" name="sampai"
                class="w-full mt-1 px-3 py-2 border rounded-lg"
                required>
        </div>

        <!-- DURASI -->
        <div>
            <label class="font-semibold">Durasi Tampil (ms)</label>
            <input type="number" name="durasi" value="8000"
                class="w-full mt-1 px-3 py-2 border rounded-lg">
            <small class="text-gray-500">Default: 8000 ms (8 detik)</small>
        </div>

        <!-- STATUS -->
        <div class="flex items-center space-x-3">
            <input type="checkbox" name="enabled" checked>
            <label>Aktif</label>
        </div>

        <!-- SUBMIT -->
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Simpan Pengumuman
        </button>

    </form>

</div>

<!-- SCRIPT -->
<script>
function pengumumanForm() {
    return {
        kategori: '',

        applyTemplate() {
            let isi = document.getElementById('isiField');
            

            // jika belum memilih kategori, kosongkan
            if (!this.kategori) {
                isi.value = "";
                return;
            }

            if (this.kategori === 'keuangan_jumat') {
                isi.value =
`Saldo Jumat pekan lalu=Rp [nominal],-
Total Penerimaan=Rp [nominal],-
Total Pengeluaran=Rp [nominal],-
Saldo per [DD] [Bulan] [YYYY]=Rp [nominal],-`;
            }
            else if (this.kategori === 'imam_khatib') {
                isi.value =
`Imam :
Khatib :
Tema Khutbah :
`;
            }
            else if (this.kategori === 'umum') {
                isi.value = "";
            }
        }
    }
}
</script>

<?= $this->endSection() ?>
