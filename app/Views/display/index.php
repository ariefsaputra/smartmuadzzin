<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TV Informasi Masjid</title>

    <!-- Tailwind CSS (CDN, atau gunakan versi build sendiri jika offline) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SwiperJS untuk carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        /* Animasi marquee sederhana */
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body class="bg-black text-white">

    <div class="w-screen h-screen overflow-hidden bg-gradient-to-br from-green-950 via-black to-emerald-900 text-white font-[\'Noto Serif\',serif]">
        <div class="grid grid-cols-10 gap-0 h-[calc(100%-3rem)]">
            <!-- Kolom Kiri: Nama Masjid & Jadwal Sholat -->
            <div class="col-span-10 md:col-span-3 bg-gradient-to-b from-green-900/40 to-emerald-800/30 backdrop-blur-xl rounded-none shadow-xl border-r border-green-700/30 flex flex-col justify-start space-y-4 overflow-y-auto p-4">
                <h1 class="text-3xl font-bold text-center text-emerald-200 tracking-wide drop-shadow-md border-b border-emerald-500 pb-2">
                    <?= esc($pengaturan['nama_masjid'] ?? 'Nama Masjid') ?>
                </h1>

                <!-- Nama Kota -->
                <div class="text-sm text-center text-white/70 tracking-wide uppercase">
                    <?= esc($pengaturan['nama_kota'] ?? 'Kota Bandung') ?>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-1 gap-2">
                    <?php
                    $labelMap = [
                        'imsak' => 'Imsak',
                        'subuh' => 'Subuh',
                        'terbit' => 'Terbit',
                        'dzuhur' => 'Dzuhur',
                        'ashar' => 'Ashar',
                        'maghrib' => 'Maghrib',
                        'isya' => 'Isya',
                    ];
                    foreach ($labelMap as $key => $label):
                        $waktu = $jadwal[$key] ?? '--:--';
                    ?>
                        <div class="bg-emerald-100/10 p-2 rounded-xl border border-emerald-400/20 flex justify-between items-center px-3" data-key="<?= $key ?>">
                            <div class="text-xs text-emerald-200 uppercase font-medium text-left"><?= $label ?></div>
                            <div class="text-lg font-semibold text-yellow-200 text-right"><?= substr($waktu, 0, 5) ?></div>
                        </div>
                    <?php endforeach ?>

                    <!-- Informasi Hari, Tanggal & Jam -->
                    <div class="mt-1 text-center space-y-1">
                        <div id="tanggal-komplit" class="text-base md:text-xl text-center text-white font-semibold py-1"></div>
                        <div id="clock" class="text-[4rem] md:text-[6rem] font-extrabold tracking-widest text-yellow-100 drop-shadow-lg leading-tight"></div>
                    </div>

                </div>
            </div>

            <!-- Kolom Kanan: Carousel + Jam + Countdown -->
            <div class="col-span-10 md:col-span-7 relative rounded-none overflow-hidden shadow-xl">
                <div class="absolute inset-0">
                    <div class="swiper mySwiper w-full h-full">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Masjid_al-Haram%2C_Mecca_at_night.jpg" alt="Masjidil Haram" class="w-full h-full object-cover">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://thesaudiboom.com/wp-content/uploads/2025/04/1-Over-3-Million-Worshippers-Gathered-at-Two-Holy-Mosques-on-27th-Night-of-Ramadan.png" alt="Masjid Nabawi" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80 backdrop-blur-sm"></div>

                <!-- Gradient Bayangan Atas + Info Sholat Berikutnya -->
                <div class="absolute top-0 left-0 right-0 z-20 px-6 pt-4 pb-4 bg-gradient-to-b from-black/70 to-transparent text-center">
                    <div class="flex flex-wrap md:flex-nowrap justify-center items-center gap-2 md:gap-4 text-white/90 text-lg md:text-xl font-semibold">
                        <span class="text-white/60">Menuju waktu sholat berikutnya</span>
                        <span id="nextPrayerName" class="text-yellow-400 font-bold">---</span>
                        <span id="countdown" class="text-yellow-300 font-extrabold text-2xl md:text-3xl">--:--:--</span>
                    </div>
                </div>

                <!-- Panel Overlay untuk Adzan dan Iqamah -->
                <div id="overlayAdzan" class="absolute inset-0 bg-black bg-opacity-90 z-50 flex flex-col items-center justify-center hidden">
                    <div id="judulAdzan" class="text-white text-4xl md:text-6xl font-bold mb-4">Adzan</div>
                    <div id="countdownAdzanIqamah" class="text-yellow-300 text-4xl md:text-6xl font-extrabold tracking-wide">--:--</div>
                </div>

            </div>
        </div>

        <!-- Running Text -->
        <div class="w-full h-12 bg-gradient-to-r from-emerald-900 to-green-800 overflow-hidden text-white whitespace-nowrap flex items-center">
            <div class="animate-marquee text-xl px-8">
                <?= esc($runningText ?? 'Selamat datang di Masjid kami. Mari jaga ketertiban dan kebersihan.') ?>
            </div>
        </div>
    </div>

    <!-- SCRIPT tambahan -->
    <script>
        // Data waktu sholat dari PHP
        const waktuSholat = <?= json_encode($jadwal) ?>;

        const urutan = ['imsak', 'subuh', 'terbit', 'dzuhur', 'ashar', 'maghrib', 'isya'];
        const labelMap = {
            imsak: 'Imsak',
            subuh: 'Subuh',
            terbit: 'Terbit',
            dzuhur: 'Dzuhur',
            ashar: 'Ashar',
            maghrib: 'Maghrib',
            isya: 'Isya'
        };

        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}`;
        }

        function getNextPrayerTime() {
            const now = new Date();
            const nowMinutes = now.getHours() * 60 + now.getMinutes();

            for (let i = 0; i < urutan.length; i++) {
                const waktu = waktuSholat[urutan[i]];
                if (!waktu) continue;

                const [hh, mm] = waktu.split(':').map(Number);
                const totalMinutes = hh * 60 + mm;

                if (totalMinutes > nowMinutes) {
                    return {
                        name: urutan[i],
                        time: new Date(now.getFullYear(), now.getMonth(), now.getDate(), hh, mm, 0)
                    };
                }
            }

            // fallback ke imsak besok
            const [hh, mm] = waktuSholat['imsak'].split(':').map(Number);
            const besok = new Date(now);
            besok.setDate(besok.getDate() + 1);
            return {
                name: 'imsak',
                time: new Date(besok.getFullYear(), besok.getMonth(), besok.getDate(), hh, mm, 0)
            };
        }

        function updateCountdown() {
            const {
                name,
                time
            } = getNextPrayerTime();
            const now = new Date();
            const diff = Math.floor((time - now) / 1000); // dalam detik

            const hours = String(Math.floor(diff / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
            const seconds = String(diff % 60).padStart(2, '0');

            document.getElementById('nextPrayerName').textContent = labelMap[name] ?? name;
            document.getElementById('countdown').textContent = `${hours}:${minutes}:${seconds}`;
        }

        function highlightSholatAktif() {
            const now = new Date();
            const menitSekarang = now.getHours() * 60 + now.getMinutes();

            let aktifKey = null;
            for (let i = 0; i < urutan.length; i++) {
                const key = urutan[i];
                const waktuAwal = waktuSholat[key];
                const waktuAkhir = waktuSholat[urutan[i + 1]];

                if (!waktuAwal || !waktuAkhir) continue;

                const [jamAwal, menitAwal] = waktuAwal.split(':').map(Number);
                const [jamAkhir, menitAkhir] = waktuAkhir.split(':').map(Number);

                const start = jamAwal * 60 + menitAwal;
                const end = jamAkhir * 60 + menitAkhir;

                if (menitSekarang >= start && menitSekarang < end) {
                    aktifKey = key;
                    break;
                }
            }

            document.querySelectorAll('[data-key]').forEach(el => {
                el.classList.remove(
                    'bg-yellow-200/10',
                    'ring-2',
                    'ring-yellow-400',
                    'animate-pulse',
                    'shadow-yellow-500',
                    'shadow-md'
                );
            });

            if (aktifKey) {
                const el = document.querySelector(`[data-key="${aktifKey}"]`);
                if (el) {
                    el.classList.add(
                        'bg-yellow-200/10',
                        'ring-2',
                        'ring-yellow-400',
                        'animate-pulse',
                        'shadow-yellow-500',
                        'shadow-md'
                    );
                }
            }
        }

        // Jalankan semua saat halaman dimuat
        updateClock();
        updateCountdown();
        highlightSholatAktif();

        // Looping terus
        setInterval(updateClock, 1000);
        setInterval(updateCountdown, 1000);
        setInterval(highlightSholatAktif, 60000);
    </script>

    <script>
        // Mapping bulan Hijriyah ke Bahasa Indonesia
        const bulanHijriyahID = {
            "Muharram": "Muharram",
            "Safar": "Safar",
            "Rabi al-awwal": "Rabiul Awal",
            "Rabi al-thani": "Rabiul Akhir",
            "Jumada al-awwal": "Jumadil Awal",
            "Jumada al-thani": "Jumadil Akhir",
            "Rajab": "Rajab",
            "Sha'ban": "Sya'ban",
            "Ramadan": "Ramadhan",
            "Shawwal": "Syawal",
            "Dhul Qa'dah": "Dzulkaidah",
            "Dhul Hijjah": "Dzulhijjah"
        };

        // Mapping hari ke Bahasa Indonesia
        const hariID = {
            "Sunday": "Ahad",
            "Monday": "Senin",
            "Tuesday": "Selasa",
            "Wednesday": "Rabu",
            "Thursday": "Kamis",
            "Friday": "Jumat",
            "Saturday": "Sabtu"
        };

        // Ambil data hijriyah dan tampilkan gabungan
        fetch('https://api.aladhan.com/v1/gToH?date=<?= date("d-m-Y") ?>')
            .then(res => res.json())
            .then(data => {
                if (data && data.data && data.data.hijri) {
                    const hijri = data.data.hijri;

                    const tanggalHijriyah = `${hijri.day} ${bulanHijriyahID[hijri.month.en] ?? hijri.month.en} ${hijri.year} H`;

                    const now = new Date();
                    const hari = hariID[now.toLocaleDateString('en-US', {
                        weekday: 'long'
                    })];
                    const tanggalMasehi = now.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

                    const teksGabungan = `${hari}, ${tanggalMasehi} | ${tanggalHijriyah}`;
                    document.getElementById('tanggal-komplit').textContent = teksGabungan;
                }
            })
            .catch(err => {
                console.error("Gagal ambil Hijriyah", err);
                document.getElementById('tanggal-komplit').textContent = "Tanggal tidak tersedia";
            });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper(".mySwiper", {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
                speed: 1000,
            });
        });
    </script>

    <script>
        let adzanStartTime = null;
        let stateAdzan = false;
        const durasiAdzan = 5 * 60; // 5 menit
        const durasiIqamah = 5 * 60; // 5 menit
        let iqamahCountdown = false;

        function cekMasukAdzan() {
            const now = new Date();
            const nowMinutes = now.getHours() * 60 + now.getMinutes();
            const nowSeconds = now.getSeconds();

            for (let i = 0; i < urutan.length; i++) {
                const waktu = waktuSholat[urutan[i]];
                if (!waktu) continue;

                const [hh, mm] = waktu.split(':').map(Number);
                const waktuMenit = hh * 60 + mm;

                // Cek apakah sekarang adalah detik pertama adzan
                if (nowMinutes === waktuMenit && nowSeconds === 0 && !stateAdzan) {
                    mulaiAdzan();
                    break;
                }
            }

            if (stateAdzan) {
                updateAdzanIqamahCountdown();
            }
        }

        function mulaiAdzan() {
            adzanStartTime = new Date();
            stateAdzan = true;
            iqamahCountdown = false;

            // Tampilkan overlay
            document.getElementById('overlayAdzan').classList.remove('hidden');
            document.getElementById('judulAdzan').textContent = "Adzan";
        }

        function updateAdzanIqamahCountdown() {
            const now = new Date();
            const elapsed = Math.floor((now - adzanStartTime) / 1000);

            if (elapsed < durasiAdzan) {
                const sisa = durasiAdzan - elapsed;
                document.getElementById('countdownAdzanIqamah').textContent = formatCountdown(sisa);
            } else if (!iqamahCountdown) {
                // Mulai Iqamah
                adzanStartTime = new Date();
                iqamahCountdown = true;
                document.getElementById('judulAdzan').textContent = "Menuju Iqamah";
            } else {
                const sisa = durasiIqamah - Math.floor((now - adzanStartTime) / 1000);
                if (sisa > 0) {
                    document.getElementById('countdownAdzanIqamah').textContent = formatCountdown(sisa);
                } else {
                    // Selesai Iqamah
                    stateAdzan = false;
                    iqamahCountdown = false;
                    document.getElementById('overlayAdzan').classList.add('hidden');
                }
            }
        }

        function formatCountdown(detik) {
            const m = String(Math.floor(detik / 60)).padStart(2, '0');
            const s = String(detik % 60).padStart(2, '0');
            return `${m}:${s}`;
        }

        setInterval(cekMasukAdzan, 1000);
    </script>


</body>

</html>