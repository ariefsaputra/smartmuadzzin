<!DOCTYPE html>
<html lang="id" class="h-full w-full">

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

<body class="h-full w-full bg-sky-100 text-slate-800 font-sans">
    <!-- HEADER -->
    <header class="bg-amber-900 text-white px-6 py-4 flex justify-between items-center shadow-xl">
        <!-- Jam Digital -->
        <div id="jam-digital" class="text-7xl font-bold tracking-widest flex items-center gap-1">
            <span id="jam">00</span>
            <span id="separator">:</span>
            <span id="menit">00</span>
        </div>

        <div class="text-center max-w-full">
            <!-- Nama Masjid -->
            <h1 class="text-4xl font-bold uppercase tracking-wide text-white drop-shadow-md">
                <?= esc($pengaturan['nama_masjid'] ?? 'Nama Masjid') ?>
            </h1>

            <!-- Alamat Masjid -->
            <div class="mt-1 overflow-hidden whitespace-nowrap relative h-8">
                <p id="alamatMasjid"
                    class="text-xl font-medium text-white/90 inline-block px-4 animate-marquee-on-overflow">
                    <?= esc($pengaturan['alamat'] ?? 'Alamat Masjid') ?>
                </p>
            </div>
        </div>

        <!-- Hari & Tanggal -->
        <div
            x-data="{
                tanggalM: '',
                tanggalH: '<?= esc($jadwal['tanggal_hijriyah'] ?? 'Hijriyah') ?>', // ← nanti bisa diganti otomatis
                init() {
                const now = new Date();
                const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                this.tanggalM = now.toLocaleDateString('id-ID', options);
                }
            }"
            x-init="init()"
            class="text-right leading-tight">
            <p x-text="tanggalM" class="text-3xl font-bold"></p>
            <p x-text="tanggalH" class="text-2xl italic text-white/70"></p>
        </div>
    </header>

    <!-- MAIN SLIDER -->
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

                <!-- Card Imsak -->
                <div data-sholat="imsak" data-warna="gray-500"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-gray-500 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Imsak</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['imsak'], 0, 5) ?></p>
                </div>

                <!-- Card Subuh -->
                <div data-sholat="subuh" data-warna="yellow-500"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-yellow-500 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Shubuh</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['subuh'], 0, 5) ?></p>
                </div>

                <!-- Card Syuruq -->
                <div data-sholat="syuruq" data-warna="orange-400"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-orange-400 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Syuruq</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['syuruq'], 0, 5) ?></p>
                </div>

                <!-- Card Dhuha -->
                <div data-sholat="dhuha" data-warna="yellow-400"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-yellow-400 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Dhuha</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['dhuha'], 0, 5) ?></p>
                </div>

                <!-- Card Dzuhur -->
                <div data-sholat="dzuhur" data-warna="blue-400"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-blue-400 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Dzuhur</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['dzuhur'], 0, 5) ?></p>
                </div>

                <!-- Card Ashar -->
                <div data-sholat="ashar" data-warna="green-400"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-green-400 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Ashar</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['ashar'], 0, 5) ?></p>
                </div>

                <!-- Card Maghrib -->
                <div data-sholat="maghrib" data-warna="red-400"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-red-400 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Maghrib</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['maghrib'], 0, 5) ?></p>
                </div>

                <!-- Card Isya -->
                <div data-sholat="isya" data-warna="purple-400"
                    class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-purple-400 transition-all duration-300">
                    <h2 class="text-xl font-semibold">Isya'</h2>
                    <p class="text-4xl font-bold"><?= substr($jadwal['isya'], 0, 5) ?></p>
                </div>

            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-blue-900 text-white py-3 shadow-inner">
        <div class="overflow-hidden whitespace-nowrap">
            <div class="animate-marquee inline-block">
                🕌 Selamat Datang di Masjid Al Ukhuwwah Komp. Griya Saluyu | 📅 Jadwal Sholat Hari Ini | 🧼 Jaga Kebersihan • 🤲 Jaga Kekhusyukan • 📢 Adzan akan berkumandang tepat waktu
            </div>
        </div>
    </footer>

    <!-- Admin Panel Fullscreen -->
    <div id="admin-panel" x-data="{ showAdmin: false, activeTab: 'masjid' }">
        <!-- Tombol Setting -->
        <a href="#" @click="showAdmin = true; loadPengaturan()"
            class="fixed top-1/2 right-0 transform -translate-y-1/2 translate-x-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-l-full px-3 py-2 shadow-md z-50">
            ⚙️
        </a>

        <!-- Panel -->
        <div x-show="showAdmin" x-transition
            class="fixed inset-0 bg-white z-50 overflow-auto"
            style="display: none;">

            <!-- Header -->
            <div class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
                <h2 class="text-xl font-bold">Pengaturan TV Masjid</h2>
                <button id="btn-close-admin" @click="showAdmin = false" class="text-white text-2xl">✖</button>
            </div>

            <!-- Tabs -->
            <div class="border-b bg-gray-100 px-6">
                <nav class="flex space-x-4 pt-4">
                    <button @click="activeTab = 'masjid'"
                        :class="activeTab === 'masjid' ? 'border-b-4 border-blue-600 text-blue-700 font-bold' : 'text-gray-600'"
                        class="pb-3 px-2">🏠 Masjid</button>

                    <button @click="activeTab = 'jadwal'"
                        :class="activeTab === 'jadwal' ? 'border-b-4 border-blue-600 text-blue-700 font-bold' : 'text-gray-600'"
                        class="pb-3 px-2">🕒 Jadwal Sholat</button>

                    <button @click="activeTab = 'durasi'"
                        :class="activeTab === 'durasi' ? 'border-b-4 border-blue-600 text-blue-700 font-bold' : 'text-gray-600'"
                        class="pb-3 px-2">⏱ Durasi</button>
                </nav>
            </div>

            <!-- Konten Tab -->
            <div class="p-6 space-y-6">
                <!-- Tab 1: Info Masjid -->
                <div x-show="activeTab === 'masjid'" x-transition>
                    <h3 class="text-lg font-semibold mb-2">Informasi Masjid</h3>
                    <div class="space-y-4">
                        <div>
                            <label>Nama Masjid</label>
                            <input type="text" class="w-full border rounded px-3 py-2" placeholder="Masjid Al-Falah" id="namaMasjid">
                        </div>
                        <div>
                            <label>ID Kota (MyQuran API)</label>
                            <input type="text" class="w-full border rounded px-3 py-2" placeholder="3273" id="idKota">
                        </div>
                        <div>
                            <label>Alamat Masjid</label>
                            <textarea class="w-full border rounded px-3 py-2" rows="3" placeholder="Jl. Cibogo No. 25, Bandung" id="alamatMasjid"></textarea>
                        </div>

                        <button onclick="simpanPengaturan()" class="bg-green-600 text-white px-4 py-2 rounded">
                            💾 Simpan Pengaturan
                        </button>
                    </div>
                </div>

                <!-- Tab 2: Sinkronisasi Jadwal -->
                <div x-show="activeTab === 'jadwal'" x-transition>
                    <h3 class="text-lg font-semibold mb-2">Sinkronisasi Jadwal Sholat</h3>
                    <div class="space-y-4">
                        <button onclick="syncHariIni()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">
                            🔄 Sinkron Hari Ini
                        </button>
                        <button onclick="syncSebulan()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                            📅 Sinkron Bulan Ini
                        </button>
                        <button onclick="syncSetahun()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded w-full">
                            📆 Sinkron 1 Tahun
                        </button>

                        <div class="mt-4 bg-gray-100 p-4 rounded border text-sm text-gray-700">
                            <strong>Status:</strong> Jadwal terakhir diupdate <span id="lastUpdate">-</span>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Durasi Adzan & Iqamah -->
                <div x-show="activeTab === 'durasi'" x-transition>
                    <h3 class="text-lg font-semibold mb-2">Pengaturan Durasi per Waktu Sholat</h3>

                    <template x-for="waktu in ['shubuh', 'dzuhur', 'ashar', 'maghrib', 'isya']">
                        <div class="border p-4 rounded-md bg-gray-50 mb-4">
                            <h4 class="font-bold capitalize mb-2" x-text="waktu"></h4>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label>Adzan (detik)</label>
                                    <input :id="'durasi_' + waktu + '_adzan'" type="number" class="w-full border rounded px-2 py-1">
                                </div>
                                <div>
                                    <label>Iqamah (detik)</label>
                                    <input :id="'durasi_' + waktu + '_iqamah'" type="number" class="w-full border rounded px-2 py-1">
                                </div>
                                <div>
                                    <label>Sholat (detik)</label>
                                    <input :id="'durasi_' + waktu + '_sholat'" type="number" class="w-full border rounded px-2 py-1">
                                </div>
                            </div>
                        </div>
                    </template>

                    <button onclick="simpanPengaturan()" class="bg-green-600 text-white px-4 py-2 rounded">
                        💾 Simpan Pengaturan
                    </button>
                </div>

            </div>

        </div>
    </div>

    <!-- Overlay Adzan/Iqamah/Sholat -->
    <div id="overlay-waktu-sholat" class="fixed inset-0 z-50 hidden bg-gradient-to-b from-black via-gray-900 to-black text-white flex flex-col items-center justify-center transition-all duration-500">
        <!-- Judul Utama (ADZAN / IQAMAH / SHOLAT) -->
        <h1 id="judul-overlay" class="text-8xl font-extrabold tracking-wide mb-4 uppercase drop-shadow-2xl animate-pulse">
            ADZAN
        </h1>

        <!-- Nama Waktu Sholat -->
        <p id="keterangan-overlay" class="text-5xl font-semibold text-yellow-300 drop-shadow-lg mb-6">
            Shubuh
        </p>

        <!-- Countdown -->
        <p id="countdown-overlay" class="text-7xl font-mono font-bold bg-white/10 px-6 py-4 rounded-2xl border border-white/30 shadow-2xl tracking-wider">
            02:00
        </p>

        <!-- Quote Ringan -->
        <?php /*<div class="mt-12 text-center text-lg text-white/50 italic">
            <p>“Hayya 'ala ash-shalah... Hayya 'ala al-falah...”</p>
        </div>*/ ?>
    </div>

    <audio id="audio-alarm" src="<?= site_url('assets/sounds/default-alarm.mp3'); ?>" preload="auto"></audio>
    <button onclick="document.getElementById('audio-alarm').play()" class="hidden">Aktifkan Suara</button>

    <!-- Notifikasi ringan -->
    <div id="notifikasi-ringkas" class="fixed top-20 right-6 z-40 bg-yellow-400 text-black text-xl font-semibold px-6 py-4 rounded-xl shadow-lg hidden transition-all duration-500">
        <span id="isi-notifikasi">Notifikasi</span>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const alamat = document.getElementById('alamatMasjid');
            const container = alamat.parentElement;

            if (alamat.scrollWidth <= container.clientWidth) {
                alamat.classList.remove('animate-marquee-on-overflow');
            }
        });
    </script>

    <script>
        new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 4000
            },
            effect: 'fade',
        });

        const jadwalSholat = <?= json_encode($jadwal) ?>;
        const waktuAktifOverlay = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

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
        };
    </script>
    <script src="<?= site_url('assets/js/script.js'); ?>"></script>
    <script src="<?= site_url('assets/js/script-admin.js'); ?>"></script>
    <script>

    </script>
</body>

</html>