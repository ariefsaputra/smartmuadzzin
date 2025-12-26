<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $data['nama_masjid'] ?> — SMARTMUADZZIN</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="<?= site_url('assets/js/tailwindcss.js'); ?>"></script>
    <script src="<?= site_url('assets/js/alpine.min.js'); ?>" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('clock', {
                now: '',
                nowHHMM: '',
                nowSS: '',
                dateMasehi: '',
                dayName: '',
                dateFull: ''
            });


        });
    </script>

    <link rel="stylesheet" href="<?= site_url("assets/styles.css") ?>">
    <style>
        /* small overrides / additional styles kept here for convenience */
        /* ensure Mode3 background uses same image as Mode1 */
        .bg-mode1 {
            background-image: url('<?= base_url("assets/bg/mosque-bg-spesial.jpg") ?>');
        }

        .mode3-bg {
            position: absolute;
            inset: 0;
            background-image: url('<?= base_url("assets/bg/mosque-bg-spesial.jpg") ?>');
            background-size: cover;
            background-position: center;
            filter: brightness(0.45) saturate(.95);
            z-index: 30;
        }

        /* Mode3 content wrapper */
        .mode3-wrapper {
            position: relative;
            z-index: 40;
            max-width: 1200px;
            width: calc(100% - 48px);
            margin: 0 24px;
        }

        /* announcement content tweaks */
        .ann-title {
            font-size: clamp(28px, 3.6vw, 44px);
        }

        .ann-content {
            font-size: clamp(18px, 2.3vw, 26px);
        }

        .ann-table th {
            text-align: left;
            padding: 10px 12px;
            color: #fff;
            font-weight: 700;
        }

        .ann-table td {
            padding: 10px 12px;
            color: #eef7ff;
            text-align: right;
            font-weight: 600;
        }
    </style>

</head>

<body x-data="tvPlayer()" x-init="init()" class="antialiased">

    <!-- AUDIO -->
    <audio id="adzanAlarm" src="<?= base_url('audio/default-alarm.mp3') ?>" preload="auto"></audio>

    <!-- =========================== -->
    <!-- MODE 1 : MAIN DISPLAY       -->
    <!-- =========================== -->
    <div :class="!showMain ? 'hidden' : 'block'" class="h-screen w-screen relative overflow-hidden transition-opacity duration-700 ease-in-out">

        <!-- BACKGROUND IMAGE -->
        <div class="bg-mode1 absolute inset-0"></div>

        <!-- MAIN CONTENT LAYER -->
        <div class="mode1-content h-full w-full flex flex-col relative">

            <!-- MASJID TITLE CARD -->
            <div class="w-full flex justify-center pt-8">
                <div class="title-card text-center title-anim">
                    <div class="text-white text-5xl font-extrabold drop-shadow-lg leading-tight">
                        <?= esc($data['nama_masjid']) ?>
                    </div>
                    <div class="masjid-alamat">
                        <?= esc($data['alamat_masjid']) ?>
                    </div>

                </div>
            </div>

            <!-- CLOCK MIDDLE -->
            <div class="absolute inset-0 flex flex-col justify-center items-center pointer-events-none select-none">
                <div id="bigClock" class="clock-big text-white"></div>

                <!-- Date card (Masehi + Hijri) -->
                <div class="date-card date-anim mt-4">
                    <div id="bigDate" class="date-masehi"></div>
                    <div class="date-hijri">
                        <?= esc($jadwal['hijriyah'] ?? '') ?>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- ============================== -->
    <!-- MODE 2 (MEDIA) -->
    <!-- ============================== -->
    <div :class="!showMain ? 'container-full show' : 'container-full hide'" class="relative w-screen h-screen overflow-hidden">

        <!-- MEDIA SLIDER -->
        <template x-for="(m, index) in medias" :key="index">
            <div x-show="currentSlide === index" class="absolute inset-0">
                <img x-show="m.type==='image'" :src="m.url" class="w-full h-full object-cover">
                <video x-show="m.type==='video'" :src="m.url" class="w-full h-full object-cover" autoplay muted loop></video>
            </div>
        </template>

        <!-- TOP BAR -->
        <div class="absolute top-5 left-0 right-0 flex justify-between px-6">

            <!-- LEFT — CLOCK CARD -->
            <div class="mode2-card mode2-clock-card" :class="!showMain ? 'mode2-card-anim' : 'mode2-card-hide'">
                <div id="smallClock" class="mode2-clock-text font-bold tracking-wider"></div>
            </div>

            <!-- RIGHT — DATE CARD -->
            <div class="mode2-card text-right" :class="!showMain ? 'mode2-card-anim' : 'mode2-card-hide'">
                <div id="smallDay" class="text-3xl font-extrabold tracking-wide mb-1 mode2-day"></div>
                <div id="smallHijri" class="text-base opacity-90 font-medium mode2-hijri"><?= esc($jadwal['hijriyah'] ?? '') ?></div>
                <div id="smallDate" class="text-base opacity-80 mt-1 mode2-date"></div>
            </div>

        </div>

    </div>

    <!-- ============================== -->
    <!-- MODE 3 (PENGUMUMAN) FULLSCREEN -->
    <!-- ============================== -->
    <div x-show="showAnnouncement" class="absolute inset-0 z-40 flex items-center justify-center transition-opacity duration-500">

        <!-- background (same as mode1 image) -->
        <div class="mode3-bg"></div>

        <!-- TOP BAR SMALL CLOCK & DATE (Mode 3) -->
        <div class="absolute top-5 left-0 right-0 flex justify-between px-6 z-50">

            <!-- SMALL CLOCK -->
            <div class="mode2-card mode2-clock-card mode3-card-anim">
                <div id="smallClock_m3" class="mode2-clock-text font-bold tracking-wider"></div>
            </div>

            <!-- SMALL DATE -->
            <div class="mode2-card text-right mode3-card-anim">
                <div id="smallDay_m3" class="text-3xl font-extrabold tracking-wide mb-1 mode2-day"></div>
                <div id="smallHijri_m3" class="text-base opacity-90 font-medium mode2-hijri">
                    <?= esc($jadwal['hijriyah'] ?? '') ?>
                </div>
                <div id="smallDate_m3" class="text-base opacity-80 mt-1 mode2-date"></div>
            </div>

        </div>

        <!-- glass card -->
        <div class="mode3-wrapper relative p-8">
            <div class="relative bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 p-8 shadow-2xl">
                <h1 id="annTitle" class="ann-title text-white font-extrabold mb-4"></h1>

                <div id="annContent" class="ann-content text-white"></div>
            </div>
        </div>

    </div>

    <!-- PERSISTENT PRAYER FOOTER (muncul di semua mode) -->
    <div id="persistentPrayer" aria-hidden="true">
        <div class="prayer-grid px-4">
            <?php
            $items = [
                ['Imsak',   $jadwal['imsak'],   'p-imsak'],
                ['Subuh',   $jadwal['subuh'],   'p-subuh'],
                ['Syuruq',  $jadwal['syuruq'],  'p-syuruq'],
                ['Dhuha',   $jadwal['dhuha'],   'p-dhuha'],
                ['Dzuhur',  $jadwal['dzuhur'],  'p-dzuhur'],
                ['Ashar',   $jadwal['ashar'],   'p-ashar'],
                ['Maghrib', $jadwal['maghrib'], 'p-maghrib'],
                ['Isya',    $jadwal['isya'],    'p-isya'],
            ];
            foreach ($items as $i):
            ?>
                <div class="prayer-box">
                    <div class="prayer-premium <?= $i[2] ?>" data-time="<?= $i[1] ?>">
                        <div class="label"><?= $i[0] ?></div>
                        <div class="time"><?= $i[1] !== '--:--' ? date('H:i', strtotime($i[1])) : '--:--' ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RUNNING TEXT ALWAYS VISIBLE (FIXED BOTTOM) -->
    <div id="runningBar" class="running-bar">
        <div id="runningWrapper">
            <span id="runningText">
                <?= esc($running_text ?: "Selamat datang di Masjid " . $data['nama_masjid']) ?>
            </span>
        </div>
    </div>



    <!-- OVERLAY (Adzan / Iqamah / etc) -->
    <?= $this->include('overlay_adzan'); ?>

    <!-- ============================== -->
    <!-- ALPINE.JS CONTROLLER -->
    <!-- ============================== -->
    <script>
        function tvPlayer() {
            return {
                /* =========================
                   Initial state & data
                ========================== */
                showMain: true,
                showAnnouncement: false,
                mode: 1, // 1=Main, 2=Media, 3=Announcement
                modeTimer: null,

                // slides
                currentSlide: 0,
                slideTimer: null,
                medias: [
                    <?php foreach ($medias as $m): ?> {
                            url: "<?= base_url('writable/uploads/' . $m['filename']) ?>",
                            type: "<?= $m['type'] ?>",
                            duration: <?= (int)$m['duration'] ?: 5000 ?>
                        },
                    <?php endforeach; ?>
                ],

                // announcements (from DB)
                announcements: [
                    <?php foreach ($pengumuman as $p): ?> {
                            id: <?= $p['id'] ?>,
                            kategori: "<?= $p['kategori'] ?>",
                            judul: `<?= esc($p['judul']) ?>`,
                            isi: `<?= esc($p['isi']) ?>`,
                            duration: <?= (int)$p['durasi'] ?: 8000 ?>
                        },
                    <?php endforeach; ?>
                ],
                currentAnnouncement: 0,
                announcementTimer: null,

                // prayer times (from controller)
                prayerTimes: {
                    imsak: "<?= $jadwal['imsak'] ?>",
                    subuh: "<?= $jadwal['subuh'] ?>",
                    syuruq: "<?= $jadwal['syuruq'] ?>",
                    dhuha: "<?= $jadwal['dhuha'] ?>",
                    dzuhur: "<?= $jadwal['dzuhur'] ?>",
                    ashar: "<?= $jadwal['ashar'] ?>",
                    maghrib: "<?= $jadwal['maghrib'] ?>",
                    isya: "<?= $jadwal['isya'] ?>"
                },

                overlay: {
                    active: false,
                    state: null,
                    namaSholat: '',
                    countdown: ''
                },

                /* =========================
                   Audio
                ========================== */
                playAlarm() {
                    let alarm = document.getElementById("adzanAlarm");
                    if (!alarm) return;
                    alarm.pause();
                    alarm.currentTime = 0;
                    alarm.volume = 0.8;
                    alarm.play().catch(() => {});
                },

                stopAlarm() {
                    let alarm = document.getElementById("adzanAlarm");
                    if (!alarm) return;
                    alarm.pause();
                    alarm.currentTime = 0;
                },

                runMode() {
                    clearTimeout(this.modeTimer);

                    console.log('MODE:', this.mode);

                    // MODE 1 — MAIN (FIX 30s)
                    if (this.mode === 1) {
                        this.showMain = true;
                        this.showAnnouncement = false;
                        this.stopSlides();
                        this.stopAnnouncements();

                        this.modeTimer = setTimeout(() => {
                            if (this.medias.length > 0) {
                                this.mode = 2;
                            } else if (this.announcements.length > 0) {
                                this.mode = 3;
                            }
                            this.runMode();
                        }, 30000);
                    }

                    // MODE 2 — MEDIA (DINAMIS)
                    else if (this.mode === 2) {
                        this.showMain = false;
                        this.showAnnouncement = false;
                        this.startSlides();

                        const dur = this.totalSlideDuration();
                        this.modeTimer = setTimeout(() => {
                            this.stopSlides();
                            this.mode = (this.announcements.length > 0) ? 3 : 1;
                            this.runMode();
                        }, dur);
                    }

                    // MODE 3 — ANNOUNCEMENT (DINAMIS)
                    else if (this.mode === 3) {
                        this.showMain = false;
                        this.showAnnouncement = true;
                        this.playAnnouncements();

                        const dur = this.totalAnnouncementDuration();
                        this.modeTimer = setTimeout(() => {
                            this.stopAnnouncements();
                            this.mode = 1;
                            this.runMode();
                        }, dur);
                    }
                },

                totalSlideDuration() {
                    return this.medias.reduce((s, m) => s + (parseInt(m.duration) || 5000), 0);
                },



                /* =========================
                   Init
                ========================== */
                init() {
                    window.smartTv = this;
                    this.startPrayerWatcher();

                    // mulai dari MODE 1
                    this.mode = 1;
                    this.runMode();

                    highlightActive();
                    setInterval(highlightActive, 1000);
                },

                /* =========================
                   Slides (Mode 2)
                ========================== */
                startSlides() {
                    this.showMain = false;
                    this.playSlide(0);
                },

                stopSlides() {
                    clearTimeout(this.slideTimer);
                    this.slideTimer = null;
                },

                playSlide(i) {
                    this.currentSlide = i;
                    const dur = this.medias[i]?.duration || 5000;

                    clearTimeout(this.slideTimer);
                    this.slideTimer = setTimeout(() => {
                        let next = (i + 1) % this.medias.length;
                        this.playSlide(next);
                    }, dur);
                },


                /* =========================
                   Announcements (Mode 3)
                ========================== */
                playAnnouncements() {
                    this.showAnnouncement = true;
                    this.showMain = false;

                    this.renderCurrentAnnouncement();

                    clearTimeout(this.announcementTimer);
                    const dur = parseInt(this.announcements[this.currentAnnouncement]?.duration) || 8000;

                    this.announcementTimer = setTimeout(() => {
                        this.currentAnnouncement =
                            (this.currentAnnouncement + 1) % this.announcements.length;
                        this.playAnnouncements();
                    }, dur);
                },

                stopAnnouncements() {
                    clearTimeout(this.announcementTimer);
                    this.announcementTimer = null;
                    this.showAnnouncement = false;
                    this.currentAnnouncement = 0;
                },

                renderCurrentAnnouncement() {
                    const ann = this.announcements[this.currentAnnouncement];
                    // title
                    const titleEl = document.getElementById('annTitle');
                    const contentEl = document.getElementById('annContent');
                    if (titleEl) titleEl.innerText = ann.judul || '';
                    if (!contentEl) return;

                    // render by category
                    if (ann.kategori === 'keuangan_jumat') {
                        let rows = ann.isi.split('\n').filter(r => r.trim() !== '');
                        let html = `<table class="ann-table w-full">`;
                        rows.forEach(r => {
                            let parts = r.split('=');
                            let label = (parts[0] || '').trim();
                            let val = (parts[1] || '').trim();
                            html += `<tr><th>${label}</th><td>${val}</td></tr>`;
                        });
                        html += `</table>`;
                        contentEl.innerHTML = html;
                        return;
                    }

                    if (ann.kategori === 'imam_khatib') {
                        let lines = ann.isi.split('\n').map(l => l.trim()).filter(l => l !== '');
                        let html = `<div class="space-y-3">`;
                        lines.forEach(l => html += `<div class="text-2xl">${l}</div>`);
                        html += `</div>`;
                        contentEl.innerHTML = html;
                        return;
                    }

                    // default umum
                    contentEl.innerHTML = `<div class="text-left whitespace-pre-line">${ann.isi}</div>`;
                },

                totalAnnouncementDuration() {
                    return this.announcements.reduce((s, a) => s + (parseInt(a.duration) || 8000), 0);
                },

                /* =========================
                   Prayer watcher & overlay logic
                   - Important: when overlay becomes ACTIVE -> stop announcements & slides and show Mode1
                   - If announcements are running and overlay is NOT active -> do not interrupt
                ========================== */
                startPrayerWatcher() {
                    setInterval(() => this.checkPrayerState(), 1000);
                },

                checkPrayerState() {
                    const now = new Date();
                    const day = now.getDay(); // 5 = Jumat

                    const DUR = {
                        menjelangAdzan: parseInt(<?= $pengaturan['menjelang_adzan'] ?? 600 ?>) || 600,
                        adzan: 4.5 * 60,
                        menjelangIqamah: parseInt(<?= $pengaturan['menjelang_iqamah'] ?? 300 ?>) || 300,
                        waktuSholat: parseInt(<?= $pengaturan['waktu_sholat'] ?? 600 ?>) || 600,
                        khutbahJumat: parseInt(<?= $pengaturan['khutbah_jumat'] ?? 1800 ?>) || 1800
                    };

                    const setOverlay = (active, state = null, nama = '', countdown = '') => {

                        if (active && this.showAnnouncement) {
                            this.stopAnnouncements();
                            this.showMain = true;
                        }

                        if (this.overlayTimer) {
                            clearTimeout(this.overlayTimer);
                            this.overlayTimer = null;
                        }

                        this.overlay.active = active;
                        this.overlay.state = state;
                        this.overlay.namaSholat = nama;
                        this.overlay.countdown = countdown;

                        if (state === 'waktu_sholat' || state === 'jumat_sholat') {
                            this.overlayTimer = setTimeout(() => {
                                this.overlay.active = false;
                                this.overlay.state = null;
                                this.overlay.namaSholat = '';
                                this.overlay.countdown = '';
                            }, DUR.waktuSholat * 1000);
                        }
                    };

                    // ================================
                    // KHUSUS JUMAT (DZUHUR SAJA)
                    // ================================
                    if (day === 5) {
                        const waktuDzuhur = this.prayerTimes.dzuhur;
                        if (waktuDzuhur && waktuDzuhur !== '--:--') {

                            const target = new Date(now.toDateString() + " " + waktuDzuhur);
                            const diff = (target - now) / 1000;

                            // Menjelang Adzan Jumat
                            if (diff > 0 && diff <= DUR.menjelangAdzan) {
                                if (this.overlay.state !== 'jumat_pre') {
                                    this.playAlarm();
                                    setTimeout(() => this.stopAlarm(), 6000);
                                }
                                setOverlay(true, 'jumat_pre', 'JUMAT', this.formatCountdown(diff));
                                return;
                            }

                            // Adzan Jumat
                            if (diff <= 0 && diff > -DUR.adzan) {
                                if (this.overlay.state !== 'jumat_adzan') {
                                    this.playAlarm();
                                    setTimeout(() => this.stopAlarm(), 6000);
                                }
                                setOverlay(true, 'jumat_adzan', 'JUMAT', '');
                                return;
                            }

                            // Khutbah Jumat
                            if (diff <= -DUR.adzan && diff > -(DUR.adzan + DUR.khutbahJumat)) {
                                setOverlay(true, 'jumat_khutbah', 'JUMAT', '');
                                return;
                            }

                            // Sholat Jumat
                            if (
                                diff <= -(DUR.adzan + DUR.khutbahJumat) &&
                                diff > -(DUR.adzan + DUR.khutbahJumat + DUR.waktuSholat)
                            ) {
                                setOverlay(true, 'jumat_sholat', 'JUMAT', '');
                                return;
                            }

                            // Setelah Jumat selesai
                            if (diff <= -(DUR.adzan + DUR.khutbahJumat + DUR.waktuSholat)) {
                                setOverlay(false);
                                return;
                            }
                        }
                    }

                    // ================================
                    // NORMAL (SUBUH, DZUHUR*, ASHAR, MAGHRIB, ISYA)
                    // * Dzuhur hanya non-Jumat
                    // ================================
                    const wajib = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

                    for (let nama of wajib) {

                        if (day === 5 && nama === 'dzuhur') continue;

                        const waktu = this.prayerTimes[nama];
                        if (!waktu || waktu === '--:--') continue;

                        const target = new Date(now.toDateString() + " " + waktu);
                        const diff = (target - now) / 1000;

                        // Menjelang adzan
                        if (diff > 0 && diff <= DUR.menjelangAdzan) {
                            if (this.overlay.state !== 'menjelang_adzan') {
                                this.playAlarm();
                                setTimeout(() => this.stopAlarm(), 6000);
                            }
                            setOverlay(true, 'menjelang_adzan', nama.toUpperCase(), this.formatCountdown(diff));
                            return;
                        }

                        // Adzan
                        if (diff <= 0 && diff > -DUR.adzan) {
                            if (this.overlay.state !== 'adzan') {
                                this.playAlarm();
                                setTimeout(() => this.stopAlarm(), 6000);
                            }
                            setOverlay(true, 'adzan', nama.toUpperCase(), '');
                            return;
                        }

                        // Menjelang iqamah
                        if (diff <= -DUR.adzan && diff > -(DUR.adzan + DUR.menjelangIqamah)) {
                            if (this.overlay.state !== 'menjelang_iqamah') {
                                this.playAlarm();
                                setTimeout(() => this.stopAlarm(), 6000);
                            }
                            const sisa = (DUR.adzan + DUR.menjelangIqamah) + diff;
                            setOverlay(true, 'menjelang_iqamah', nama.toUpperCase(), this.formatCountdown(sisa));
                            return;
                        }

                        // Waktu sholat
                        if (
                            diff <= -(DUR.adzan + DUR.menjelangIqamah) &&
                            diff > -(DUR.adzan + DUR.menjelangIqamah + DUR.waktuSholat)
                        ) {

                            if (this.overlay.state !== 'waktu_sholat') {
                                this.playAlarm();
                                setTimeout(() => this.stopAlarm(), 6000);
                            }

                            setOverlay(true, 'waktu_sholat', nama.toUpperCase(), '');
                            return;
                        }
                    }

                    // ================================
                    // RESET JIKA TIDAK ADA STATE
                    // ================================
                    if (this.overlay.active) {
                        setOverlay(false);
                    }
                },


                formatCountdown(sec) {
                    sec = Math.max(0, Math.floor(sec));
                    let m = String(Math.floor(sec / 60)).padStart(2, '0');
                    let s = String(sec % 60).padStart(2, '0');
                    return `${m}:${s}`;
                }
            };
        }
    </script>

    <!-- CLOCK & DATE -->
    <script>
        function updateClock() {
            const now = new Date();

            // Format jam
            const fullTime = now.toLocaleTimeString("en-GB", {
                hour12: false
            });
            const hhmm = fullTime.slice(0, 5);
            const ss = fullTime.slice(6, 8);


            // Format tanggal
            const tanggalFull = now.toLocaleDateString("id-ID", {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            const hari = now.toLocaleDateString("id-ID", {
                weekday: 'long'
            });

            // =========================
            // SAFE: update Alpine store only if Alpine & store ready
            // =========================
            try {
                if (window.Alpine && typeof Alpine.store === 'function' && Alpine.store('clock')) {
                    Alpine.store('clock').now = fullTime;
                    Alpine.store('clock').nowHHMM = hhmm;
                    Alpine.store('clock').nowSS = ss;
                    Alpine.store('clock').dayName = hari;
                    Alpine.store('clock').dateFull = tanggalFull;
                }
            } catch (e) {
                // ignore if store not ready yet
            }

            // =========================
            // Always update DOM elements directly as fallback
            // =========================

            // MODE 1 — BIG CLOCK
            const bigClock = document.getElementById("bigClock");
            if (bigClock) bigClock.textContent = fullTime;

            const bigDate = document.getElementById("bigDate");
            if (bigDate) bigDate.textContent = `${hari}, ${tanggalFull}`;

            // MODE 2 — SMALL CLOCK
            const sc = document.getElementById("smallClock");
            if (sc) sc.textContent = hhmm;

            const sd = document.getElementById("smallDay");
            if (sd) sd.textContent = hari;

            const sDate = document.getElementById("smallDate");
            if (sDate) sDate.textContent = tanggalFull;

            // MODE 3 — SMALL CLOCK
            const sc3 = document.getElementById("smallClock_m3");
            if (sc3) sc3.textContent = hhmm;

            const sd3 = document.getElementById("smallDay_m3");
            if (sd3) sd3.textContent = hari;

            const sDate3 = document.getElementById("smallDate_m3");
            if (sDate3) sDate3.textContent = tanggalFull;

            // OVERLAY: jika kamu menaruh jam overlay dengan x-text="$store.clock.nowHHMM",
            // Alpine akan men-setnya ketika store tersedia; tapi untuk keamanan kita juga
            // update overlay tempat jika ada elemen fallback (opsional).
            const overlayClockFallback = document.getElementById("overlayClockFallback");
            if (overlayClockFallback) overlayClockFallback.textContent = hhmm;
        }

        // Jalankan setiap detik — aman karena updateClock tidak langsung mengakses Alpine tanpa guard
        setInterval(updateClock, 1000);
        updateClock();
    </script>


    <!-- ACTIVE PRAYER HIGHLIGHT (persistent footer) -->
    <script>
        function highlightActive() {
            const now = new Date();
            const items = document.querySelectorAll(".prayer-premium");
            let prayerList = [];

            items.forEach(el => {
                let t = el.dataset.time;
                if (!t || t === "--:--") return;

                let dt = new Date(now.toDateString() + " " + t);
                if (!isNaN(dt)) {
                    prayerList.push({
                        el,
                        dt
                    });
                }
            });

            // Sort waktu sholat
            prayerList.sort((a, b) => a.dt - b.dt);

            // Reset semua warna & aktif
            items.forEach(el => el.classList.remove("active-prayer"));

            for (let i = 0; i < prayerList.length; i++) {
                let curr = prayerList[i];
                let next = prayerList[(i + 1) % prayerList.length];

                let start = curr.dt;
                let end = next.dt;

                // Lewati ke hari berikutnya kalau perlu (shubuh hari berikutnya)
                if (end < start) {
                    end = new Date(end.getTime() + 24 * 3600 * 1000);
                }

                // Jika sekarang berada di range jam
                if (now >= start && now < end) {
                    curr.el.classList.add("active-prayer");
                    break;
                }
            }
        }

        setInterval(highlightActive, 1000);
        highlightActive();
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const text = document.getElementById("runningText");
            const wrapper = document.getElementById("runningWrapper");

            if (!text || !wrapper) return;

            // Jika teks terlalu pendek → duplikasi agar animasi tetap panjang & smooth
            if (text.offsetWidth < wrapper.offsetWidth) {
                text.innerHTML += " — " + text.innerHTML;
            }
        });
    </script>

</body>

</html>