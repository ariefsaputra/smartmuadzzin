<?=$this->extend('layouts/main')?>
<?=$this->section('content')?>
<!-- Main Content Section -->
<main class="relative h-[80vh]">
    <!-- background slider -->
    <div class="absolute inset-0 z-0">
        <!-- Swiper -->
        <div class="swiper swiper-container h-full">
            <div class="swiper-wrapper">
                <!-- melakukan pengecekan apakah ada background -->
                <?php if (empty($backgrounds)): ?>
                    <div class="swiper-slide">
                        <img src="<?= site_url('assets/img/1.jpg'); ?>" class="object-cover w-full h-full" />
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= site_url('assets/img/2.jpg'); ?>" class="object-cover w-full h-full" />
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= site_url('assets/img/2-2.jpg'); ?>" class="object-cover w-full h-full" />
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= site_url('assets/img/3.jpg'); ?>" class="object-cover w-full h-full" />
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= site_url('assets/img/4.jpg'); ?>" class="object-cover w-full h-full" />
                    </div>
                <?php else: ?>
                <?php foreach ($backgrounds as $bg): ?>
                    <div class="swiper-slide">
                        <img src=""<?= site_url('assets/img/' . $bg['filename']); ?>" class="object-cover w-full h-full" />
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- Card waktu Sholat -->
        <?=$this->include('layouts/partials/card_sholat'); ?>
    </div>
</main>
<!-- End of Main Content Section -->
<?=$this->endSection()?>