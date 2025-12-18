<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Media Slider</h1>
    <a href="<?= base_url('admin/media/create') ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
        Tambah Media
    </a>
</div>

<?php if(empty($media)): ?>

<!-- ===========================================
     EMPTY STATE (Jika Tidak Ada Media)
=========================================== -->
<div class="text-center py-16 bg-white rounded-xl border">
    <div class="text-gray-500 text-lg mb-3">Belum ada media yang ditambahkan</div>
    <div class="text-sm text-gray-400 mb-6">Silakan mulai dengan mengupload gambar atau video.</div>

    <a href="<?= base_url('admin/media/create') ?>"
       class="px-5 py-3 bg-blue-600 text-white rounded-lg font-medium">
       Tambah Media Pertama
    </a>
</div>

<?php else: ?>

<!-- ===========================================
     LIST MEDIA + SORTABLE
=========================================== -->
<div x-data="sortable()" class="space-y-3">

    <?php foreach($media as $m): ?>
    <div class="p-3 border rounded-lg flex items-center gap-4 bg-white cursor-move"
         data-id="<?= $m['id'] ?>" draggable="true">

        <?php if($m['type']=='image'): ?>
            <img src="<?= base_url('writable/uploads/'.$m['filename']) ?>"
                 class="w-20 h-20 object-cover rounded">
        <?php else: ?>
            <video src="<?= base_url('writable/uploads/'.$m['filename']) ?>"
                   class="w-20 h-20 object-cover rounded"></video>
        <?php endif; ?>

        <div class="flex-1">
            <div class="font-semibold"><?= $m['title'] ?></div>
            <div class="text-sm text-gray-500"><?= strtoupper($m['type']) ?></div>
            <div class="text-xs text-gray-400">Durasi: <?= $m['duration'] ?> ms</div>
        </div>

        <div>
            <a href="<?= base_url('admin/media/edit/'.$m['id']) ?>" class="text-blue-600 mr-3">Edit</a>
            <a href="<?= base_url('admin/media/delete/'.$m['id']) ?>"
               onclick="return confirm('Hapus media ini?')"
               class="text-red-600">Hapus</a>
        </div>

    </div>
    <?php endforeach; ?>

</div>

<?php endif; ?>


<script>
function sortable() {
    return {
        init() {
            let drag;

            this.$el.querySelectorAll("[draggable=true]").forEach(el => {
                el.addEventListener("dragstart", () => drag = el);
                el.addEventListener("dragover", e => e.preventDefault());
                el.addEventListener("drop", () => {
                    if (drag !== el) {
                        const parent = this.$el;
                        parent.insertBefore(drag, el);

                        const ids = [...parent.children].map(i => i.dataset.id);

                        fetch("<?= base_url('admin/media/reorder') ?>", {
                            method: "POST",
                            headers: {"Content-Type": "application/x-www-form-urlencoded"},
                            body: "order[]=" + ids.join("&order[]=")
                        });
                    }
                });
            });
        }
    }
}
</script>

<?= $this->endSection() ?>
