<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Edit Media</h1>

<form action="<?= base_url('admin/media/update/' . $m['id']) ?>" method="post" class="space-y-4">

    <div>
        <label>Judul</label>
        <input type="text" name="title" value="<?= $m['title'] ?>" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Status</label>
        <select name="enabled" class="w-full p-2 border rounded">
            <option value="1" <?= $m['enabled'] == 1 ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= $m['enabled'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
        </select>
    </div>

    <div>
        <label>Durasi (ms)</label>
        <input type="number" name="duration" value="<?= $m['duration'] ?>" class="w-full p-2 border rounded">
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>

</form>

<?= $this->endSection() ?>