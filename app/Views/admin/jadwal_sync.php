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
document.getElementById("btnSync").onclick = async () => {

    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;

    const wrap = document.getElementById('progressWrapper');
    const bar  = document.getElementById('progressBar');
    const txt  = document.getElementById('progressText');

    wrap.classList.remove('hidden');
    bar.style.width = "0%";
    txt.innerText = "0%";

    const url = "<?= base_url('admin/jadwal/sync') ?>";

    const payload = new URLSearchParams({
        bulan,
        tahun,
        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
    });

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: payload
        });
        if (!response.ok || !response.body) throw new Error('Sync gagal dimulai');

        const reader = response.body.getReader();
        const decoder = new TextDecoder();
        let buffer = '';

        while (true) {
            const {done, value} = await reader.read();
            if (done) break;
            buffer += decoder.decode(value, {stream: true});
            const events = buffer.split("\n\n");
            buffer = events.pop();
            for (const event of events) {
                const line = event.split("\n").find(item => item.startsWith('data: '));
                if (!line) continue;
                const data = JSON.parse(line.slice(6));
                if (data.error) throw new Error(data.error);
                const p = Math.floor((data.progress / data.total) * 100);
                bar.style.width = p + "%";
                txt.innerText = p + "%";
            }
        }
        txt.innerHTML = "<span class='text-green-600 font-semibold'>Selesai ✓</span>";
    } catch (error) {
        txt.innerHTML = "<span class='text-red-600 font-semibold'>Gagal memuat data.</span>";
    }
};
</script>

<?= $this->endSection() ?>
