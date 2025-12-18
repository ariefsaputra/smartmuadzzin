<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

    <h2 class="text-2xl font-bold mb-4">Edit Pengumuman</h2>

    <form action="<?= base_url('admin/pengumuman/update/'.$pengumuman['id']) ?>" 
          method="post" x-data="editPengumuman()" x-init="initData()">

        <!-- JUDUL -->
        <div class="mb-4">
            <label class="font-semibold">Judul</label>
            <input type="text" name="judul"
                value="<?= esc($pengumuman['judul']) ?>"
                class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <!-- KATEGORI -->
        <div class="mb-4">
            <label class="font-semibold">Kategori</label>
            <select name="kategori" id="kategori" 
                x-model="kategori" @change="applyTemplateEdit()"
                class="w-full mt-1 border rounded px-3 py-2">

                <option value="keuangan_jumat"
                    <?= $pengumuman['kategori']=='keuangan_jumat' ? 'selected' : '' ?>>
                    Laporan Keuangan Jumat
                </option>

                <option value="imam_khatib"
                    <?= $pengumuman['kategori']=='imam_khatib' ? 'selected' : '' ?>>
                    Info Imam/Khatib Jumat
                </option>

                <option value="umum"
                    <?= $pengumuman['kategori']=='umum' ? 'selected' : '' ?>>
                    Pengumuman Umum
                </option>
            </select>
        </div>

        <!-- ISI -->
        <div class="mb-4">
            <label class="font-semibold">Isi Pengumuman</label>
            <textarea name="isi" id="isiField"
                class="w-full h-60 mt-1 border rounded px-3 py-2"><?= esc($pengumuman['isi']) ?></textarea>
        </div>

        <!-- DURASI -->
        <div class="mb-4">
            <label class="font-semibold">Durasi Tampil (ms)</label>
            <input type="number" name="durasi"
                value="<?= esc($pengumuman['durasi']) ?>"
                class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <!-- ENABLED -->
        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" name="enabled" value="1"
                <?= $pengumuman['enabled'] ? 'checked' : '' ?>>
            <span class="font-semibold">Aktifkan Pengumuman</span>
        </div>

        <button class="bg-blue-600 text-white px-5 py-2 rounded shadow">
            Update
        </button>

    </form>
</div>

<script>
function editPengumuman() {
    return {
        kategori: "<?= $pengumuman['kategori'] ?>",

        initData() {
            document.getElementById("isiField").value = `<?= esc($pengumuman['isi']) ?>`;
        },

        applyTemplateEdit() {
            let isi = document.getElementById("isiField");

            // Jangan overwrite jika kategori tetap sama
            if (this.kategori === "<?= $pengumuman['kategori'] ?>") return;

            if (this.kategori === 'keuangan_jumat') {
                isi.value =
`Pemasukan Kotak Jumat=
Infak Pembangunan=
Donatur Tetap=
Pengeluaran Operasional=
`;
            }

            else if (this.kategori === 'imam_khatib') {
                isi.value =
`Imam :
Khatib :
Tema Khutbah : 
`;
            }

            else {
                isi.value = "";
            }
        }
    }
}
</script>

<?= $this->endSection() ?>
