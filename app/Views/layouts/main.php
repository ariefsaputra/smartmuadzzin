<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TV Informasi Masjid</title>
    <script src="<?= site_url('assets/js/tailwindcss.min.js'); ?>"></script>
    <script src="<?= site_url('assets/js/alpinejs.min.js'); ?>" defer></script>
    <link rel="stylesheet" href="<?= site_url('assets/css/swiper-bundle.min.css'); ?>" />
    <script src="<?= site_url('assets/js/swiper-bundle.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= site_url('assets/css/style.css'); ?>">
</head>

<body>
    <!-- Header Section -->
    <?= $this->include('layouts/partials/header'); ?>
    <!-- Content Section -->
    <?= $this->renderSection('content'); ?>
    <!-- Overlay Section -->
    <?= $this->include('layouts/partials/overlay'); ?>
    <!-- Modal Section -->
    <?= $this->include('layouts/partials/modal'); ?>
    <!-- Footer Section -->
    <?= $this->include('layouts/partials/footer'); ?>

    <!-- audio alarm adzan -->
    <audio id="audio-alarm" src="<?= site_url('assets/sounds/default-alarm.mp3'); ?>" preload="auto"></audio>
    <button onclick="document.getElementById('audio-alarm').play()" class="hidden">Aktifkan Suara</button>

    <!-- javaScript Section -->
    <script>
        const now = new Date(); // Waktu sekarang
        const jadwalSholat = <?= json_encode($jadwal) ?>; // Data jadwal sholat dari backend
        const durasi = {
            adzan: {
                subuh: <?= $pengaturan['durasi_shubuh_adzan'] ?>,
                dzuhur: <?= $pengaturan['durasi_dzuhur_adzan'] ?>,
                ashar: <?= $pengaturan['durasi_ashar_adzan'] ?>,
                maghrib: <?= $pengaturan['durasi_maghrib_adzan'] ?>,
                isya: <?= $pengaturan['durasi_isya_adzan'] ?>,
            },
            iqamah: {
                subuh: <?= $pengaturan['durasi_shubuh_iqamah'] ?>,
                dzuhur: <?= $pengaturan['durasi_dzuhur_iqamah'] ?>,
                ashar: <?= $pengaturan['durasi_ashar_iqamah'] ?>,
                maghrib: <?= $pengaturan['durasi_maghrib_iqamah'] ?>,
                isya: <?= $pengaturan['durasi_isya_iqamah'] ?>,
            },
            sholat: {
                subuh: <?= $pengaturan['durasi_shubuh_sholat'] ?>,
                dzuhur: <?= $pengaturan['durasi_dzuhur_sholat'] ?>,
                ashar: <?= $pengaturan['durasi_ashar_sholat'] ?>,
                maghrib: <?= $pengaturan['durasi_maghrib_sholat'] ?>,
                isya: <?= $pengaturan['durasi_isya_sholat'] ?>,
            }
        }; // Durasi dalam detik
    </script>
    <!-- Script setting audio adzan -->
    <script src="<?= site_url('assets/js/setup-audio.js'); ?>"></script>
    <!-- Script setup jam digital -->
    <script src="<?= site_url('assets/js/setup-jam-utama.js'); ?>"></script>
    <!-- Script setup waktu sholat -->
    <script src="<?= site_url('assets/js/setup-waktu-sholat.js'); ?>"></script>
    
    <!-- Main Script -->
    <script src="<?= site_url('assets/js/main.js'); ?>"></script>
</body>
</html>