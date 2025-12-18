<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-xl shadow-sm border max-w-xl">

    <h3 class="text-xl font-semibold mb-6">Sync Jadwal Sholat</h3>

    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-sm text-gray-600">Kota Masjid</p>
        <p class="text-lg font-semibold text-blue-700"><?= $nama_kota ?> (<?= $kode_kota ?>)</p>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="text-sm text-gray-600">Bulan</label>
            <input type="number" id="bulan" class="w-full mt-1 p-2 border rounded-lg" value="<?= date('m') ?>">
        </div>

        <div>
            <label class="text-sm text-gray-600">Tahun</label>
            <input type="number" id="tahun" class="w-full mt-1 p-2 border rounded-lg" value="<?= date('Y') ?>">
        </div>
    </div>

    <button id="btnSync"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 w-full">
        Mulai Sync
    </button>

    <!-- PROGRESS -->
    <div id="progressWrapper" class="mt-6 hidden">
        <div class="text-sm text-gray-600 mb-2">Proses Sync</div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div id="progressBar" class="h-3 bg-blue-600 rounded-full" style="width:0%"></div>
        </div>
        <div id="progressText" class="text-sm text-gray-600 mt-2">0%</div>
    </div>

</div>

<script>
document.getElementById("btnSync").onclick = () => {

    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;

    const wrap = document.getElementById('progressWrapper');
    const bar  = document.getElementById('progressBar');
    const txt  = document.getElementById('progressText');

    wrap.classList.remove('hidden');
    bar.style.width = "0%";
    txt.innerText = "0%";

    const url = "<?= base_url('admin/jadwal/sync') ?>";

    const evtSource = new EventSource(url + "?" +
        new URLSearchParams({bulan:bulan,tahun:tahun})
    );

    evtSource.onmessage = function(event) {
        const data = JSON.parse(event.data);
        const p = Math.floor((data.progress / data.total) * 100);

        bar.style.width = p + "%";
        txt.innerText = p + "%";

        if (p >= 100) {
            txt.innerHTML = "<span class='text-green-600 font-semibold'>Selesai ✓</span>";
            evtSource.close();
        }
    };

    evtSource.onerror = function() {
        evtSource.close();
        txt.innerHTML = "<span class='text-red-600 font-semibold'>Gagal memuat data.</span>";
    };
};
</script>

<?= $this->endSection() ?>
