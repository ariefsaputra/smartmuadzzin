<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-xl shadow-sm border max-w-xl">

    <h3 class="text-xl font-semibold mb-4">Input Jadwal Sholat</h3>

    <form method="post">

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="text-sm text-gray-600">Tanggal</label>
                <input type="date" name="tanggal" class="w-full mt-1 p-2 border rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Subuh</label>
                <input type="time" name="subuh" class="w-full mt-1 p-2 border rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Dzuhur</label>
                <input type="time" name="dzuhur" class="w-full mt-1 p-2 border rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Ashar</label>
                <input type="time" name="ashar" class="w-full mt-1 p-2 border rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Maghrib</label>
                <input type="time" name="maghrib" class="w-full mt-1 p-2 border rounded-lg">
            </div>

            <div>
                <label class="text-sm text-gray-600">Isya</label>
                <input type="time" name="isya" class="w-full mt-1 p-2 border rounded-lg">
            </div>

        </div>

        <button class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Simpan Jadwal
        </button>
    </form>

</div>

<?= $this->endSection() ?>
