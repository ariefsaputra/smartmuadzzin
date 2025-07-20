<main class="relative h-[80vh]">
    <!-- Background Slider -->
    <div class="swiper h-full">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="<?= site_url('assets/img/foto-masjid.jpg'); ?>" class="object-cover w-full h-full" />
            </div>
        </div>
    </div>

    <!-- Jadwal Sholat -->
    <div class="absolute bottom-0 w-full px-6 py-4 bg-black/20 z-10">
        <div class="grid grid-cols-8 gap-3">
            <?php
            $waktu = [
                ['imsak', 'gray-500'],
                ['subuh', 'yellow-500'],
                ['syuruq', 'orange-400'],
                ['dhuha', 'yellow-400'],
                ['dzuhur', 'blue-400'],
                ['ashar', 'green-400'],
                ['maghrib', 'red-400'],
                ['isya', 'purple-400']
            ];
            foreach ($waktu as [$nama, $warna]): ?>
                <div data-sholat="<?= $nama ?>" data-warna="<?= $warna ?>"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-<?= $warna ?> transition-all duration-300">
                    <h2 class="text-xl font-semibold"><?= ucfirst($nama === 'isya' ? "Isya'" : $nama) ?></h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal[$nama], 0, 5) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>