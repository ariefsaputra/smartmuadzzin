<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Tambah Media</h1>

<form action="<?= base_url('admin/media/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4">

    <div>
        <label>Judul</label>
        <input type="text" name="title" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>File Media</label>
        <input type="file" name="file" required class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Durasi (ms)</label>
        <input type="number" name="duration" value="6000" class="w-full p-2 border rounded">
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>

</form>

<?= $this->endSection() ?>