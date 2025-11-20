// ========================================================
// 🕌 SISTEM OVERLAY & MODAL JADWAL SHOLAT — FINAL (DIPERBAIKI)
// ========================================================

// Utility waktu
function getNow() {
    return new Date();
}

const isJumat = getNow().getDay() === 5;

// -----------------------------
// ELEMENT REFERENCES
// -----------------------------
const overlay = document.getElementById('overlay-container');
const overlay_judul = document.getElementById('overlay-judul');
const overlay_deskripsi = document.getElementById('overlay-deskripsi');
const overlay_countdown = document.getElementById('overlay-countdown');
const overlay_close_btn = document.getElementById('overlay-close'); // optional close button

const modal = document.getElementById('modal-non-waktu-sholat');
const modal_judul = document.getElementById('modal-judul');
const modal_deskripsi = document.getElementById('modal-deskripsi');
const modal_countdown = document.getElementById('modal-countdown');

// Timer
let overlayIntervalTimer = null;
let overlayTimeoutTimer = null;
let modalTimer = null;
let startTimeTimer = null;

// Flags
let overlayActive = false;
let alreadyRefreshedToday = false;

// ---------- Persisted flags ----------
let adzanSudahTayang = {};
try {
    adzanSudahTayang = JSON.parse(localStorage.getItem('adzanSudahTayang')) || {};
} catch { adzanSudahTayang = {}; }

// modal flags
let modalSudahTayang = {};

// durasi fallback (detik)
const durasiDefault = { adzan: 300, iqamah: 180, sholat: 600 };

// -----------------------------
// FALLBACK getActivePrayer (only if user didn't provide one)
// -----------------------------
function getActivePrayerFallback() {
    // Requires global jadwalSholat and parseTime
    try {
        const now = getNow();
        const keys = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
        const times = keys.map(k => ({ k, t: parseTime(jadwalSholat[k]) }));

        for (let i = 0; i < times.length; i++) {
            const cur = times[i];
            const next = times[i + 1] ? times[i + 1].t : new Date(cur.t.getTime() + 24 * 3600 * 1000);
            if (now >= cur.t && now < next) return cur.k;
        }

        // if before first (subuh) of the day
        if (now < times[0].t) return 'subuh';
        // fallback
        return times[times.length - 1].k;
    } catch {
        return null;
    }
}

// resolver: gunakan fungsi eksternal bila ada, else fallback
function resolveActivePrayer() {
    if (typeof getActivePrayer === 'function') {
        try {
            const result = getActivePrayer();
            if (result) return result;
        } catch { /* ignore and fallback */ }
    }
    return getActivePrayerFallback();
}

// =========================================================
// 🔷 UPDATE KARTU SHOLAT AKTIF (pakai resolver)
// =========================================================
function updateActiveCard() {
    const aktif = resolveActivePrayer();
    if (!aktif) return;

    document.querySelectorAll('[data-sholat]').forEach(card => {
        const key = card.dataset.sholat;
        const warna = card.dataset.warna || 'blue-500';
        if (key === aktif) {
            card.classList.add(`bg-${warna}`, 'text-white');
            card.classList.remove('bg-white', 'text-black');
        } else {
            card.classList.remove(`bg-${warna}`, 'text-white');
            card.classList.add('bg-white', 'text-black');
        }
    });
}

// =========================================================
// 🔶 OVERLAY CONTROL (timers + helpers)
// =========================================================
function clearOverlayTimers() {
    if (overlayIntervalTimer) {
        clearInterval(overlayIntervalTimer);
        overlayIntervalTimer = null;
    }
    if (overlayTimeoutTimer) {
        clearTimeout(overlayTimeoutTimer);
        overlayTimeoutTimer = null;
    }
}

function updateCountdown(sec) {
    if (!overlay_countdown) return;
    const m = String(Math.floor(sec / 60)).padStart(2, '0');
    const d = String(sec % 60).padStart(2, '0');
    overlay_countdown.textContent = `${m}:${d}`;
}

function countdownDurasi(sec, onDone) {
    clearOverlayTimers();
    let sisa = Math.max(0, Math.floor(sec));
    updateCountdown(sisa);

    overlayIntervalTimer = setInterval(() => {
        sisa--;
        if (sisa < 0) {
            clearOverlayTimers();
            if (typeof onDone === 'function') onDone();
            return;
        }
        updateCountdown(sisa);
    }, 1000);
}

function hideOverlay() {
    // safe close overlay (cleanup timers, reset flag)
    clearOverlayTimers();
    if (overlay) overlay.classList.add('hidden');
    overlayActive = false;
}

// Attach close button if exists
if (overlay_close_btn) {
    overlay_close_btn.addEventListener('click', () => {
        hideOverlay();
    });
}

// =========================================================
// 🔷 TAMPILKAN OVERLAY (inti)
// =========================================================
function tampilkanOverlay(jenis, waktuSholat) {
    if (!overlay) return;

    // if overlay already active, skip; but allow forced show by caller if needed
    if (overlayActive) {
        console.log(`⛔ Overlay sedang aktif, skip ${jenis} untuk ${waktuSholat}`);
        return;
    }

    overlayActive = true;
    overlay.classList.remove('hidden');
    clearOverlayTimers();

    if (overlay_deskripsi) overlay_deskripsi.classList.add('hidden');
    if (overlay_countdown) overlay_countdown.classList.add('hidden');

    const nama = (waktuSholat || '').charAt(0).toUpperCase() + (waktuSholat || '').slice(1);

    if (jenis === 'menjelang-adzan') {
        if (overlay_judul) overlay_judul.textContent = `Menjelang Adzan ${nama}`;
        overlay_countdown && overlay_countdown.classList.remove('hidden');

        countdownDurasi(15 * 60, () => {
            overlayActive = false; // allow next overlay to set active
            tampilkanOverlay('adzan', waktuSholat);
        });

    } else if (jenis === 'adzan') {
        mainkanAlarm(0.8);
        if (overlay_judul) overlay_judul.textContent = `Adzan ${nama}`;
        overlay_countdown && overlay_countdown.classList.remove('hidden');

        const dur = (typeof durasi !== 'undefined' && durasi?.adzan?.[waktuSholat]) ? durasi.adzan[waktuSholat] : durasiDefault.adzan;
        countdownDurasi(dur, () => {
            overlayActive = false;
            if (isJumat && waktuSholat === 'dzuhur') tampilkanOverlay('khotbah', waktuSholat);
            else tampilkanOverlay('iqamah', waktuSholat);
        });

    } else if (jenis === 'iqamah') {
        if (overlay_judul) overlay_judul.textContent = `Menuju Iqamah`;
        overlay_countdown && overlay_countdown.classList.remove('hidden');

        const dur = (typeof durasi !== 'undefined' && durasi?.iqamah?.[waktuSholat]) ? durasi.iqamah[waktuSholat] : durasiDefault.iqamah;
        countdownDurasi(dur, () => {
            overlayActive = false;
            tampilkanOverlay('sholat', waktuSholat);
        });

    } else if (jenis === 'sholat') {
        mainkanAlarm(0.8);
        if (overlay_judul) overlay_judul.textContent = `Waktu Sholat`;
        if (overlay_deskripsi) {
            overlay_deskripsi.textContent = 'Rapatkan shaf dan tenanglah saat sholat.';
            overlay_deskripsi.classList.remove('hidden');
        }
        const dur = (typeof durasi !== 'undefined' && durasi?.sholat?.[waktuSholat]) ? durasi.sholat[waktuSholat] : durasiDefault.sholat;
        countdownDurasi(dur, () => {
            hideOverlay();
        });

    } else if (jenis === 'khotbah') {
        if (overlay_judul) overlay_judul.textContent = `Waktu Khotbah Jumat`;
        if (overlay_deskripsi) {
            overlay_deskripsi.textContent = 'Dengarkan khotbah dengan khusyuk.';
            overlay_deskripsi.classList.remove('hidden');
        }
        // khusus 30 menit
        overlayTimeoutTimer = setTimeout(() => {
            hideOverlay();
        }, 30 * 60 * 1000);
    }
}

// =========================================================
// 🔸 MODAL NON-SHOLAT
// =========================================================
function tampilkanModal(judul, teks, waktu) {
    if (!modal) return;
    if (modalSudahTayang[waktu]) return;

    modal.classList.remove('hidden');
    modal_judul && (modal_judul.textContent = 'Waktu ' + judul);
    modal_deskripsi && (modal_deskripsi.textContent = teks + '\nPesan ini akan hilang otomatis.');
    modal_countdown && (modal_countdown.textContent = '01:00');

    mainkanAlarm(0.3);

    if (modalTimer) {
        clearInterval(modalTimer);
        modalTimer = null;
    }
    let sisa = 60;
    modalTimer = setInterval(() => {
        sisa--;
        modal_countdown && (modal_countdown.textContent = `00:${String(sisa).padStart(2,'0')}`);
        if (sisa <= 0) {
            clearInterval(modalTimer);
            modalTimer = null;
            modal.classList.add('hidden');
        }
    }, 1000);

    modalSudahTayang[waktu] = true;
}

// =========================================================
// 🔹 CEK WAKTU NON OVERLAY (syuruq, dhuha)
// =========================================================
function cekWaktuNonOverlay() {
    try {
        const now = getNow();
        const khusus = {
            syuruq: 'Waktu syuruq telah masuk.',
            dhuha: 'Waktu dhuha telah masuk. Ayo sholat sunnah!'
        };
        for (const w in khusus) {
            try {
                const t = parseTime(jadwalSholat[w]);
                if (Math.abs(now - t) < 60000) tampilkanModal(w, khusus[w], w);
            } catch {}
        }
    } catch {}
}

// =========================================================
// 🔻 CEK OVERLAY UTAMA
// =========================================================
const waktuAktifOverlay = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

function simpanStatus() {
    try {
        localStorage.setItem('adzanSudahTayang', JSON.stringify(adzanSudahTayang));
    } catch {}
}

function initAdzanSudahTayang() {
    waktuAktifOverlay.forEach(w => {
        try {
            adzanSudahTayang[w] = getNow() > parseTime(jadwalSholat[w]);
        } catch {
            adzanSudahTayang[w] = false;
        }
    });
    simpanStatus();
}

// cek + tampil overlay 15 menit sebelum adzan
function cekDanTampilkanOverlay() {
    const now = getNow();
    resetFlagHarian();

    waktuAktifOverlay.forEach(w => {
        try {
            const t = parseTime(jadwalSholat[w]);
            const selisih = (t - now) / 1000;

            // reset flag jika sudah lewat >1 jam
            if (selisih < -3600 && adzanSudahTayang[w]) {
                adzanSudahTayang[w] = false;
                simpanStatus();
            }

            // jendela 0..900 detik
            if (!adzanSudahTayang[w] && selisih <= 900 && selisih >= 0) {
                if (!overlayActive) tampilkanOverlay('menjelang-adzan', w);
                adzanSudahTayang[w] = true;
                simpanStatus();
            }
        } catch {}
    });
}

// =========================================================
// 🚨 IMSAK SPECIAL (trigger menjelang adzan subuh without blocking normal flow)
// =========================================================
function cekImsakKeSubuh() {
    try {
        const now = getNow();
        const t = parseTime(jadwalSholat['imsak']);
        if (Math.abs(now - t) < 30000 && !overlayActive) {
            // Tampilkan overlay tapi jangan set adzanSudahTayang['subuh']
            tampilkanOverlay('menjelang-adzan', 'subuh');
        }
    } catch {}
}

// =========================================================
// RESET HARIAN (sekali per tanggal)
// =========================================================
function resetFlagHarian() {
    try {
        const today = new Date().toDateString();
        const last = localStorage.getItem('lastReset');
        if (today !== last) {
            adzanSudahTayang = {};
            modalSudahTayang = {};
            localStorage.setItem('lastReset', today);
            simpanStatus();
        }
    } catch {}
}

// =========================================================
// 🔈 SOUND
// =========================================================
function mainkanAlarm(volume = 1) {
    try {
        const audio = new Audio('/assets/sounds/default-alarm.mp3');
        audio.volume = volume;
        audio.play();
    } catch {}
}

function aktifkanSuara() {
    try {
        new Audio('/assets/sounds/click.mp3').play();
    } catch {}
}

// =========================================================
// ⏰ JAM DIGITAL (HH:MM) + SEPARATOR BERKEDIP + AUTO REFRESH 00:00
// =========================================================
function updateClockDisplay() {
    const now = getNow();
    const hh = String(now.getHours()).padStart(2, '0');
    const mm = String(now.getMinutes()).padStart(2, '0');

    const elJam = document.getElementById('jam');
    const elMenit = document.getElementById('menit');
    const elSep = document.getElementById('separator');

    if (elJam) elJam.textContent = hh;
    if (elMenit) elMenit.textContent = mm;

    // separator berkedip (2-state)
    if (elSep) elSep.style.opacity = (now.getSeconds() % 2 === 0) ? '1' : '0';

    // reset daily refresh flag and reload at 00:00 once
    if (hh === '00' && mm === '00' && !alreadyRefreshedToday) {
        alreadyRefreshedToday = true;
        console.log('🔄 Auto refresh: new day detected. Reloading page.');
        location.reload();
    }
    if (hh === '00' && Number(mm) > 1) {
        alreadyRefreshedToday = false;
    }

    // tanggal (opsional)
    const elTanggal = document.getElementById('tanggal');
    if (elTanggal) {
        elTanggal.textContent = now.toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }
}

function startTime() {
    if (startTimeTimer) clearInterval(startTimeTimer);
    updateClockDisplay();
    startTimeTimer = setInterval(updateClockDisplay, 1000);
}

// =========================================================
// 🚀 INIT
// =========================================================
window.onload = function() {
    window.addEventListener('click', aktifkanSuara, { once: true });

    startTime();

    if (!adzanSudahTayang || Object.keys(adzanSudahTayang).length === 0) {
        initAdzanSudahTayang();
    }

    updateActiveCard();
    cekWaktuNonOverlay();
    cekDanTampilkanOverlay();
    cekImsakKeSubuh();

    setInterval(() => {
        updateActiveCard();
        cekWaktuNonOverlay();
        cekDanTampilkanOverlay();
        cekImsakKeSubuh();
    }, 10000);
};
