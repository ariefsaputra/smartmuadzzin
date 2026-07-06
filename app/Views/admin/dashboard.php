<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="space-y-8">

    <!-- ========================== -->
    <!-- ROW 1 — MAIN CARDS -->
    <!-- ========================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- JADWAL SHOLAT FULL -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition">

            <?php
            $currentMode = strtolower($pengaturan['mode'] ?? 'online');
            ?>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Jadwal Sholat Hari Ini
                    </h2>

                    <div class="flex items-center gap-2 mt-2">

                        <?php if ($currentMode == 'online'): ?>

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                ● MODE ONLINE
                            </span>

                        <?php else: ?>

                            <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                ● MODE OFFLINE
                            </span>

                        <?php endif; ?>

                    </div>
                </div>

                <div class="flex items-center gap-3">

                    <span class="text-sm text-gray-500">
                        <?= date('l, d M Y') ?>
                    </span>

                    <?php if ($currentMode == 'online'): ?>

                        <a href="<?= base_url('change-mode/offline') ?>"
                            onclick="return confirm('Yakin ingin mengubah ke Mode Offline?')"
                            class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition">

                            Mode Offline

                        </a>

                    <?php else: ?>

                        <a href="<?= base_url('change-mode/online') ?>"
                            onclick="return confirm('Yakin ingin mengubah ke Mode Online?')"
                            class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition">
                            Mode Online
                        </a>

                    <?php endif; ?>

                </div>

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

            <?php
            // Ensure $apiStatusView is defined to avoid undefined variable errors
            $apiStatusView = $apiStatusView ?? [];
            $apiStatusView['ok'] = isset($apiStatusView['ok']) ? $apiStatusView['ok'] : false;
            $apiStatusView['status'] = $apiStatusView['status'] ?? '-';
            $apiStatusView['tanggal_data'] = $apiStatusView['tanggal_data'] ?? '-';
            ?>

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
                        <p class="font-medium text-gray-800">Mode Jadwal</p>
                        <p class="text-xs text-gray-500">
                            <?= ucfirst($pengaturan['mode'] ?? 'online') ?>
                        </p>
                    </div>

                    <?php if (($pengaturan['mode'] ?? 'online') == 'online'): ?>

                        <a href="<?= base_url('change-mode/offline') ?>"
                            class="text-red-600 hover:underline">
                            Offline
                        </a>

                    <?php else: ?>

                        <a href="<?= base_url('change-mode/online') ?>"
                            class="text-green-600 hover:underline">
                            Online
                        </a>

                    <?php endif; ?>

                </div>

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