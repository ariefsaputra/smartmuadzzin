<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="container mx-auto px-6 py-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Pengumuman</h1>

        <a href="<?= base_url('/admin/pengumuman/create') ?>"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Pengumuman
        </a>
    </div>

    <!-- TABLE WRAPPER -->
    <div class="bg-white rounded-lg shadow border">

        <table class="w-full table-auto text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 border-b">Judul</th>
                    <th class="px-4 py-3 border-b">Kategori</th>
                    <th class="px-4 py-3 border-b">Jadwal Tampil</th>
                    <th class="px-4 py-3 border-b">Durasi</th>
                    <th class="px-4 py-3 border-b">Status</th>
                    <th class="px-4 py-3 border-b text-right">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($rows)): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Belum ada pengumuman.
                        </td>
                    </tr>

                <?php else: ?>
                    <?php foreach ($rows as $r): ?>

                        <tr class="hover:bg-gray-50">
                            <!-- JUDUL -->
                            <td class="px-4 py-3 border-b">
                                <div class="font-semibold"><?= esc($r['judul']) ?></div>
                                <div class="text-sm text-gray-500"><?= substr(strip_tags($r['isi']), 0, 60) ?>...</div>
                            </td>

                            <!-- KATEGORI -->
                            <td class="px-4 py-3 border-b">
                                <?php
                                $colors = [
                                    'keuangan_jumat' => 'bg-green-600',
                                    'imam_khatib' => 'bg-yellow-600',
                                    'umum' => 'bg-blue-600',
                                ];

                                $labels = [
                                    'keuangan_jumat' => 'Keuangan Jumat',
                                    'imam_khatib' => 'Imam / Khatib Jumat',
                                    'umum' => 'Umum',
                                ];
                                ?>

                                <span class="text-white text-sm px-3 py-1 rounded-full <?= $colors[$r['kategori']] ?>">
                                    <?= $labels[$r['kategori']] ?>
                                </span>
                            </td>

                            <!-- JADWAL TAMPIL -->
                            <td class="px-4 py-3 border-b">
                                <div class="text-sm">
                                    <b>Mulai :</b> <?= date('d M Y H:i', strtotime($r['mulai'])) ?>
                                </div>
                                <div class="text-sm">
                                    <b>Sampai :</b> <?= date('d M Y H:i', strtotime($r['sampai'])) ?>
                                </div>
                            </td>

                            <!-- DURASI -->
                            <td class="px-4 py-3 border-b">
                                <?= $r['durasi'] ?> ms
                            </td>

                            <!-- STATUS -->
                            <td class="px-4 py-3 border-b">
                                <?php if ($r['enabled']): ?>
                                    <span class="text-green-600 font-semibold">Aktif</span>
                                <?php else: ?>
                                    <span class="text-gray-500">Tidak aktif</span>
                                <?php endif; ?>
                            </td>

                            <!-- ACTION BUTTON -->
                            <td class="px-4 py-3 border-b text-right space-x-2">

                                <a href="<?= base_url('/admin/pengumuman/edit/' . $r['id']) ?>"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <a href="<?= base_url('/admin/pengumuman/delete/' . $r['id']) ?>"
                                    onclick="return confirm('Hapus pengumuman ini?')"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    Hapus
                                </a>

                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>

<?= $this->endSection() ?>