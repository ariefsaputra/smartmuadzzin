<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="space-y-8">

    <!-- ========================== -->
    <!-- ROW 1 — MAIN CARDS -->
    <!-- ========================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- JADWAL SHOLAT FULL -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Jadwal Sholat Hari Ini</h2>
                <span class="text-sm text-gray-500"><?= date('l, d M Y') ?></span>
            </div>

            <?php
            $sholats = [
                'Imsak'   => 'imsak',
                'Subuh'   => 'subuh',
                'Syuruq'  => 'syuruq',
                'Dhuha'   => 'dhuha',
                'Dzuhur'  => 'dzuhur',
                'Ashar'   => 'ashar',
                'Maghrib' => 'maghrib',
                'Isya'    => 'isya',
            ];
            ?>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach ($sholats as $label => $key): ?>
                    <div class="p-4 rounded-xl border bg-gray-50 text-center hover:bg-gray-100 transition">
                        <p class="text-xs font-medium text-gray-500"><?= $label ?></p>
                        <h3 class="text-xl font-bold text-gray-800 mt-1">
                            <?= $jadwal[$key] ?? '-' ?>
                        </h3>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-6 text-xs text-gray-500">
                <p>Source jadwal:
                    <span class="font-medium"><?= $apiStatus['message'] ?? 'Local / Manual' ?></span>
                </p>
                <p class="mt-1">Last sync:
                    <span class="font-medium"><?= $apiStatus['last_sync'] ?? '-' ?></span>
                </p>
            </div>

        </div>

        <!-- RIGHT SIDEBAR (Media + Pengumuman dalam 1 kolom) -->
        <div class="space-y-6">

            <!-- MEDIA SLIDER SUMMARY -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">

                <p class="text-sm text-gray-500 mb-1">Media Slider</p>

                <h3 class="text-2xl font-bold text-gray-800">
                    <?= count($medias ?? []) ?>
                </h3>

                <p class="mt-3 text-sm text-gray-600">
                    Aktif: <span class="font-semibold"><?= $mediaAktif ?? count($medias ?? []) ?></span>
                </p>

                <div class="mt-4">
                    <a href="<?= base_url('admin/medias') ?>"
                        class="text-sm font-medium text-blue-600 hover:underline">
                        Kelola Media
                    </a>
                </div>

            </div>

            <!-- RUNNING TEXT (PENGUMUMAN) — DIPINDAHKAN KE ROW 1 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">

                <p class="text-sm text-gray-500 mb-1">Running Text / Pengumuman</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= count($pengumuman ?? []) ?> aktif</h3>

                <p class="text-sm text-gray-600 mt-3 line-clamp-3">
                    <?= $pengumumanTerakhir ?? '-' ?>
                </p>

                <div class="mt-4">
                    <a href="<?= base_url('admin/pengumuman') ?>" class="text-sm font-medium text-blue-600 hover:underline">
                        Kelola Pengumuman
                    </a>
                </div>

            </div>

        </div>

    </div>



    <!-- ========================== -->
    <!-- ROW 2 — API STATUS + SETTINGS (Log Aktivitas dihapus) -->
    <!-- ========================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- API STATUS -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">

            <h3 class="text-sm text-gray-500 mb-3">Status Data Jadwal Sholat</h3>

            <p class="text-lg font-semibold <?= $apiStatusView['ok'] ? 'text-green-600' : 'text-red-600' ?>">
                <?= $apiStatusView['status'] ?>
            </p>

            <p class="text-sm text-gray-600 mt-1">
                Data terakhir:
                <span class="font-medium"><?= $apiStatusView['tanggal_data'] ?></span>
            </p>

            <p class="text-xs text-gray-500 mt-2">
                Hari ini: <?= date('Y-m-d') ?>
            </p>

            <a href="<?= base_url('admin/settings') ?>"
                class="inline-block mt-3 text-sm font-medium text-blue-600 hover:underline">
                Pengaturan Update Jadwal
            </a>
        </div>

        <!-- QUICK SETTINGS -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">

            <h3 class="text-sm text-gray-500 mb-3">Pengaturan Ringkas</h3>

            <div class="space-y-4 text-sm">

                <div class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Durasi Slider</p>
                        <p class="text-xs text-gray-500"><?= $settings['slider_duration'] ?? 5 ?> detik</p>
                    </div>
                    <a href="<?= base_url('admin/settings') ?>" class="text-blue-600 hover:underline">Ubah</a>
                </div>

                <div class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Mode Tampilan</p>
                        <p class="text-xs text-gray-500"><?= $settings['theme'] ?? 'Default' ?></p>
                    </div>
                    <a href="<?= base_url('admin/settings') ?>" class="text-blue-600 hover:underline">Ubah</a>
                </div>

                <div class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Auto Adzan</p>
                        <p class="text-xs text-gray-500">
                            <?= !empty($settings['auto_adzan']) ? 'Aktif' : 'Mati' ?>
                        </p>
                    </div>
                    <a href="<?= base_url('admin/settings') ?>" class="text-blue-600 hover:underline">Ubah</a>
                </div>

            </div>
        </div>

    </div>


</div>

<?= $this->endSection() ?>