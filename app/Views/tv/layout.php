<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? ($mosque['name'] ?? 'SmartMuadzzin')) ?></title>
    <script src="<?= site_url('assets/js/tailwindcss.js') ?>"></script>
    <script defer src="<?= site_url('assets/js/alpine.min.js') ?>"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-100 overflow-hidden">
<main x-data="tvDisplay()" x-init="init()" class="w-screen h-screen">
    <?= $this->include('tv/partials/header') ?>
    <?= $this->include('tv/partials/main') ?>
    <?= $this->include('tv/partials/footer') ?>
    <?= $this->include('overlay_adzan') ?>
    <?= $this->include('overlay_malam') ?>
</main>

<audio id="adzanAlarm" src="<?= base_url('audio/default-alarm.mp3') ?>" preload="auto"></audio>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('clock', {nowHHMM: '', nowSS: '', dayName: '', dateFull: ''});
});

function tvDisplay() {
    return {
        now: new Date(),
        slides: <?= json_encode($slides ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
        prayerTimes: <?= json_encode($jadwal ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
        announcements: <?= json_encode(array_map(static fn (array $item): array => [
            'kategori' => $item['kategori'],
            'judul' => $item['judul'],
            'isi' => $item['isi'],
            'durasi' => (int) ($item['durasi'] ?: 8000),
        ], $pengumuman ?? []), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
        currentSlide: 0,
        currentAnnouncement: {judul: '', isi: ''},
        mode: 1,
        modeTimer: null,
        slideTimer: null,
        announcementTimer: null,
        overlayTimer: null,
        alarmTimer: null,
        lastPrayerState: null,
        audioUnlocked: false,
        overlay: {active: false, state: null, namaSholat: '', countdown: ''},
        nightOverlay: {active: false, countdown: '00:00:00'},

        init() {
            this.updateClock();
            setInterval(() => this.updateClock(), 1000);
            this.runMode();
            this.startPrayerWatcher();
            this.startNightWatcher();
            this.reloadAtMidnight();
            this.initAudioUnlock();
        },
        // Fallback: jika browser masih memblokir autoplay bersuara sebelum ada
        // interaksi pengguna, sentuhan/klik/keydown pertama akan "meng-unlock"
        // elemen audio sehingga pemutaran berikutnya oleh playAlarm() tidak diblokir.
        initAudioUnlock() {
            const unlock = () => {
                const alarm = document.getElementById('adzanAlarm');
                if (!alarm) return;
                alarm.currentTime = 0;
                alarm.play().then(() => {
                    this.audioUnlocked = true;
                    ['click', 'keydown', 'touchstart'].forEach(e =>
                        document.removeEventListener(e, unlock)
                    );
                    setTimeout(() => {
                    alarm.pause();
                    alarm.currentTime = 0;
                    }, 2000);
                }).catch(() => {});
            };
            ['click', 'keydown', 'touchstart'].forEach(e =>
                document.addEventListener(e, unlock, {once: false})
            );
        },
        playAlarm() {
            const alarm = document.getElementById('adzanAlarm');
            if (!alarm) return;
            clearTimeout(this.alarmTimer);
            alarm.pause();
            alarm.currentTime = 0;
            alarm.play().then(() => {
                this.alarmTimer = setTimeout(() => {
                    alarm.pause();
                    alarm.currentTime = 0;
                }, 6000);
            }).catch(() => {});
        },
        updateClock() {
            this.now = new Date();
            const time = this.formatTime(this.now);
            const clock = Alpine.store('clock');
            clock.nowHHMM = time.slice(0, 5);
            clock.nowSS = time.slice(6, 8);
            clock.dayName = this.formatDay(this.now);
            clock.dateFull = this.formatDate(this.now);
        },
        formatTime(date) { return date.toLocaleTimeString('id-ID', {hour12: false}); },
        formatDay(date) { return date.toLocaleDateString('id-ID', {weekday: 'long'}); },
        formatDate(date) { return date.toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}); },
        prayerTarget(time) {
            const match = String(time).trim().match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
            if (!match) return null;
            const hours = Number(match[1]);
            const minutes = Number(match[2]);
            if (hours > 23 || minutes > 59) return null;
            const target = new Date(this.now);
            target.setHours(hours, minutes, 0, 0);
            if (target <= this.now) target.setDate(target.getDate() + 1);
            return target;
        },
        isNextPrayer(time) {
            const target = this.prayerTarget(time);
            if (!target) return false;
            const nextTime = Object.values(this.prayerTimes)
                .map((value) => this.prayerTarget(value))
                .filter((value) => value !== null)
                .reduce((earliest, value) => !earliest || value < earliest ? value : earliest, null);
            return nextTime !== null && target.getTime() === nextTime.getTime();
        },
        prayerCountdown(time) {
            const target = this.prayerTarget(time);
            //format HH:MM:SS
            const diff = target ? (target - this.now) / 1000 : 0;
            const hours = Math.floor(diff / 3600);
            const minutes = Math.floor((diff % 3600) / 60);
            const seconds = Math.floor(diff % 60);
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        },
        overlayTitle() {
            const labels = {
                menjelang_adzan: 'MENJELANG ADZAN',
                adzan: 'ADZAN',
                menjelang_iqamah: 'MENUJU IQAMAH',
                waktu_sholat: 'WAKTU SHOLAT',
                jumat_pre: 'PERSIAPAN SHOLAT JUMAT',
                jumat_adzan: 'ADZAN JUMAT',
                jumat_khutbah: 'KHUTBAH JUMAT',
                jumat_sholat: 'WAKTU SHOLAT JUMAT'
            };
            const label = labels[this.overlay.state] || '';
            if (!this.overlay.namaSholat || this.overlay.namaSholat === 'JUMAT' || (this.overlay.state && this.overlay.state.startsWith('jumat_'))) {
                return label;
            }
            return `${label} ${this.overlay.namaSholat}`;
        },
        overlayMessage() {
            const messages = {
                menjelang_adzan: 'PERSIAPKAN DIRI UNTUK SHOLAT',
                adzan: 'INSYA ALLAH DALAM',
                menjelang_iqamah: 'SEGERA RAPATKAN DAN LURUSKAN SHAF',
                waktu_sholat: 'HARAP TENANG DAN KHUSYUK',
                jumat_pre: 'MENUJU ADZAN DZUHUR',
                jumat_adzan: 'INSYA ALLAH DALAM',
                jumat_khutbah: 'HARAP TENANG DAN SIMAK KHUTBAH',
                jumat_sholat: 'HARAP TENANG DAN KHUSYUK'
            };
            return messages[this.overlay.state] || '';
        },
        totalDuration(items, key) {
            return items.reduce((total, item) => total + (parseInt(item[key], 10) || (key === 'durasi' ? 8000 : 5000)), 0);
        },
        runMode() {
            clearTimeout(this.modeTimer);
            if (this.mode === 1) {
                this.stopSlides();
                this.stopAnnouncements();
                this.modeTimer = setTimeout(() => {
                    this.mode = this.slides.length ? 2 : (this.announcements.length ? 3 : 1);
                    this.runMode();
                }, 30000);
            } else if (this.mode === 2) {
                this.startSlides();
                this.modeTimer = setTimeout(() => {
                    this.stopSlides();
                    this.mode = this.announcements.length ? 3 : 1;
                    this.runMode();
                }, this.totalDuration(this.slides, 'duration'));
            } else {
                this.startAnnouncements();
                this.modeTimer = setTimeout(() => {
                    this.stopAnnouncements();
                    this.mode = 1;
                    this.runMode();
                }, this.totalDuration(this.announcements, 'durasi'));
            }
        },
        startSlides() {
            if (!this.slides.length) return;
            const play = (index) => {
                this.currentSlide = index;
                clearTimeout(this.slideTimer);
                this.slideTimer = setTimeout(() => play((index + 1) % this.slides.length), parseInt(this.slides[index].duration, 10) || 5000);
            };
            play(0);
        },
        stopSlides() { clearTimeout(this.slideTimer); this.slideTimer = null; },
        startAnnouncements() {
            if (!this.announcements.length) return;
            const play = (index) => {
                this.currentAnnouncement = this.announcements[index];
                clearTimeout(this.announcementTimer);
                this.announcementTimer = setTimeout(() => play((index + 1) % this.announcements.length), parseInt(this.announcements[index].durasi, 10) || 8000);
            };
            play(0);
        },
        stopAnnouncements() {
            clearTimeout(this.announcementTimer);
            this.announcementTimer = null;
            this.currentAnnouncement = {judul: '', isi: ''};
        },
        announcementRows() {
            return (this.currentAnnouncement.isi || '').split('\n').filter(line => line.trim()).map(line => {
                const parts = line.split('=');
                return {label: parts.shift().trim(), value: parts.join('=').trim()};
            });
        },
        startPrayerWatcher() {
            this.checkPrayerState();
            setInterval(() => this.checkPrayerState(), 1000);
        },
        checkPrayerState() {
            const now = new Date();
            const durations = {
                pre: <?= (int) ($pengaturan['durasi_menjelang_adzan'] ?? 600) ?>,
                adzan: <?= (int) ($pengaturan['durasi_adzan'] ?? 240) ?>,
                iqamah: {
                    subuh: <?= (int) ($pengaturan['durasi_iqamah_shubuh'] ?? $pengaturan['durasi_iqamah_subuh'] ?? $pengaturan['durasi_menjelang_iqamah'] ?? 300) ?>,
                    dzuhur: <?= (int) ($pengaturan['durasi_iqamah_dzuhur'] ?? $pengaturan['durasi_menjelang_iqamah'] ?? 300) ?>,
                    ashar: <?= (int) ($pengaturan['durasi_iqamah_ashar'] ?? $pengaturan['durasi_menjelang_iqamah'] ?? 300) ?>,
                    maghrib: <?= (int) ($pengaturan['durasi_iqamah_maghrib'] ?? $pengaturan['durasi_menjelang_iqamah'] ?? 300) ?>,
                    isya: <?= (int) ($pengaturan['durasi_iqamah_isya'] ?? $pengaturan['durasi_menjelang_iqamah'] ?? 300) ?>
                },
                prayer: {
                    subuh: <?= (int) ($pengaturan['durasi_waktu_sholat_subuh'] ?? $pengaturan['durasi_waktu_sholat'] ?? 600) ?>,
                    dzuhur: <?= (int) ($pengaturan['durasi_waktu_sholat_dzuhur'] ?? $pengaturan['durasi_waktu_sholat'] ?? 600) ?>,
                    ashar: <?= (int) ($pengaturan['durasi_waktu_sholat_ashar'] ?? $pengaturan['durasi_waktu_sholat'] ?? 600) ?>,
                    maghrib: <?= (int) ($pengaturan['durasi_waktu_sholat_maghrib'] ?? $pengaturan['durasi_waktu_sholat'] ?? 600) ?>,
                    isya: <?= (int) ($pengaturan['durasi_waktu_sholat_isya'] ?? $pengaturan['durasi_waktu_sholat'] ?? 600) ?>
                },
                khutbahJumat: <?= (int) ($pengaturan['durasi_khutbah_jumat'] ?? 1200) ?>
            };
            let matched = false;
            if (now.getDay() === 5) {
                const dzuhurTime = this.prayerTimes.dzuhur;
                const jumatPrayerDuration = durations.prayer.dzuhur;
                if (dzuhurTime && dzuhurTime !== '--:--') {
                    const diff = (new Date(`${now.toDateString()} ${dzuhurTime}`) - now) / 1000;
                    if (diff > 0 && diff <= durations.pre) {
                        this.setOverlay('jumat_pre', 'JUMAT', this.countdown(diff));
                        matched = true;
                    } else if (diff <= 0 && diff > -durations.adzan) {
                        this.setOverlay('jumat_adzan', 'JUMAT', this.countdown(durations.adzan + diff));
                        matched = true;
                    } else if (diff <= -durations.adzan && diff > -(durations.adzan + durations.khutbahJumat)) {
                        this.setOverlay('jumat_khutbah', 'JUMAT', '');
                        matched = true;
                    } else if (diff <= -(durations.adzan + durations.khutbahJumat) && diff > -(durations.adzan + durations.khutbahJumat + jumatPrayerDuration)) {
                        this.setOverlay('jumat_sholat', 'JUMAT', '');
                        matched = true;
                    }
                }
            }
            if (!matched) {
                for (const name of ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']) {
                    if (now.getDay() === 5 && name === 'dzuhur') continue;
                    const time = this.prayerTimes[name];
                    if (!time || time === '--:--') continue;
                    const diff = (new Date(`${now.toDateString()} ${time}`) - now) / 1000;
                    const iqamahDuration = durations.iqamah[name];
                    const prayerDuration = durations.prayer[name];
                    if (diff > 0 && diff <= durations.pre) {
                        this.setOverlay('menjelang_adzan', name.toUpperCase(), this.countdown(diff));
                        matched = true;
                        break;
                    }
                    if (diff <= 0 && diff > -durations.adzan) {
                        this.setOverlay('adzan', name.toUpperCase(), '');
                        matched = true;
                        break;
                    }
                    if (diff <= -durations.adzan && diff > -(durations.adzan + iqamahDuration)) {
                        this.setOverlay('menjelang_iqamah', name.toUpperCase(), this.countdown(durations.adzan + iqamahDuration + diff));
                        matched = true;
                        break;
                    }
                    if (diff <= -(durations.adzan + iqamahDuration) && diff > -(durations.adzan + iqamahDuration + prayerDuration)) {
                        this.setOverlay('waktu_sholat', name.toUpperCase(), '');
                        matched = true;
                        break;
                    }
                }
            }
            if (!matched && this.overlay.active) this.clearOverlay();
        },
        startNightWatcher() {
            this.checkNightState();
            setInterval(() => this.checkNightState(), 1000);
        },
        isNightHours(date) {
            const hours = date.getHours();
            const minutes = date.getMinutes();
            // Aktif 21:00 - 03:30 (melewati tengah malam)
            if (hours >= 21) return true;
            if (hours < 3) return true;
            if (hours === 3 && minutes <= 30) return true;
            return false;
        },
        nightTarget(now) {
            const imsak = this.prayerTimes.imsak;
            const match = String(imsak).trim().match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
            const target = new Date(now);
            if (match) {
                target.setHours(Number(match[1]), Number(match[2]), 0, 0);
            } else {
                target.setHours(3, 30, 0, 0);
            }
            if (target <= now) target.setDate(target.getDate() + 1);
            return target;
        },
        checkNightState() {
            const now = new Date();
            const active = this.isNightHours(now) && !this.overlay.active;
            if (active) {
                const target = this.nightTarget(now);
                const diff = Math.max(0, Math.floor((target - now) / 1000));
                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = diff % 60;
                this.nightOverlay = {
                    active: true,
                    countdown: `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`
                };
            } else if (this.nightOverlay.active) {
                this.nightOverlay = {active: false, countdown: '00:00:00'};
            }
        },
        setOverlay(state, name, countdown) {
            const stateChanged = this.lastPrayerState !== state;
            if (stateChanged) {
                if (['menjelang_adzan', 'jumat_pre', 'adzan', 'jumat_adzan', 'waktu_sholat', 'jumat_sholat'].includes(state)) {
                    const alarm = document.getElementById('adzanAlarm');
                    if (alarm && this.audioUnlocked) {
                        clearTimeout(this.alarmTimer);
                        alarm.currentTime = 0;
                        alarm.play().then(() => {
                            this.alarmTimer = setTimeout(() => alarm.pause(), 6000);
                        }).catch(() => {});
                    }
                }
                clearTimeout(this.modeTimer);
                this.stopSlides();
                this.stopAnnouncements();
                this.mode = 1;
            }
            this.overlay = {active: true, state, namaSholat: name, countdown};
            this.lastPrayerState = state;
        },
        clearOverlay() {
            clearTimeout(this.overlayTimer);
            this.overlay = {active: false, state: null, namaSholat: '', countdown: ''};
            this.lastPrayerState = null;
            this.mode = 1;
            this.runMode();
        },
        countdown(seconds) {
            seconds = Math.max(0, Math.floor(seconds));
            return `${String(Math.floor(seconds / 60)).padStart(2, '0')}:${String(seconds % 60).padStart(2, '0')}`;
        },
        reloadAtMidnight() {
            const loadedDate = new Date().toDateString();
            setInterval(() => { if (new Date().toDateString() !== loadedDate) location.reload(); }, 60000);
        }
    };
}
</script>
</body>
</html>
