const now = new Date();
const isJumat = now.getDay() === 5; // 5 = Jumat

function updateJamDigital() {
    const now = new Date();
    const jam = String(now.getHours()).padStart(2, '0');
    const menit = String(now.getMinutes()).padStart(2, '0');
    const detik = now.getSeconds();

    document.getElementById('jam').textContent = jam;
    document.getElementById('menit').textContent = menit;

    const separator = document.getElementById('separator');
    separator.style.visibility = (detik % 2 === 0) ? 'visible' : 'hidden';
}

updateJamDigital();

function parseTime(timeStr) {
    const [h, m, s] = timeStr.split(':').map(Number);
    const now = new Date();
    return new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m, s || 0);
}

function getActivePrayer() {
    const now = new Date();
    const keys = ['imsak', 'subuh', 'syuruq', 'dhuha', 'dzuhur', 'ashar', 'maghrib', 'isya'];

    for (let i = 0; i < keys.length; i++) {
        const start = parseTime(jadwalSholat[keys[i]]);
        const end = i < keys.length - 1 ? parseTime(jadwalSholat[keys[i + 1]]) : new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
        if (now >= start && now < end) return keys[i];
    }

    return null;
}

function updateActiveCard() {
    const aktif = getActivePrayer();
    document.querySelectorAll('[data-sholat]').forEach(card => {
        const key = card.dataset.sholat;
        const warna = card.dataset.warna;
        if (key === aktif) {
            card.classList.add(`bg-${warna}`, 'text-white');
            card.classList.remove('bg-white', 'text-black');
        } else {
            card.classList.remove(`bg-${warna}`, 'text-white');
            card.classList.add('bg-white', 'text-black');
        }
    });
}

// ========== AUDIO SETUP ==========
function aktifkanSuara() {
    const audio = document.getElementById('audio-alarm');
    if (audio) {
        audio.play().then(() => {
            audio.pause();
            audio.currentTime = 0;
            console.log('🔊 Suara siap digunakan.');
        }).catch(err => {
            console.error('❌ Gagal menginisialisasi suara:', err);
        });
    }
}
window.addEventListener('click', aktifkanSuara, { once: true });

function mainkanAlarm(volume = 1.0) {
    const audio = document.getElementById('audio-alarm');
    if (!audio) {
        console.warn("⚠️ Elemen audio tidak ditemukan!");
        return;
    }

    try {
        audio.pause();
        audio.currentTime = 0;
        audio.volume = volume;
        audio.play().catch(err => console.error('❌ Audio gagal diputar:', err));
    } catch (e) {
        console.error('🎧 Kesalahan pemutaran:', e);
    }
}

// ========== OVERLAY ==========
const overlay = document.getElementById('overlay-waktu-sholat');
const judulOverlay = document.getElementById('judul-overlay');
const keteranganOverlay = document.getElementById('keterangan-overlay');
const countdownOverlay = document.getElementById('countdown-overlay');
let overlayTimer = null;

function tampilkanOverlay(jenis, waktuSholat) {
    overlay.classList.remove('hidden');

    if (jenis === 'khutbah') {
        judulOverlay.textContent = 'KHUTBAH JUMAT';
        keteranganOverlay.textContent = 'Harap Tenang';
        countdownOverlay.textContent = '';
        overlayTimer = setTimeout(() => overlay.classList.add('hidden'), 1800 * 1000);
        return;
    }

    judulOverlay.textContent = jenis.toUpperCase();
    keteranganOverlay.textContent = waktuSholat.charAt(0).toUpperCase() + waktuSholat.slice(1);

    if (jenis === 'adzan') {
        countdownDurasi(durasi.adzan[waktuSholat], () => {
            if (isJumat && waktuSholat === 'dzuhur') {
                tampilkanOverlay('khutbah', waktuSholat);
            } else {
                tampilkanOverlay('iqamah', waktuSholat);
            }
        });
    } else if (jenis === 'iqamah') {
        countdownDurasi(durasi.iqamah[waktuSholat], () => {
            tampilkanOverlay('sholat', waktuSholat);
        });
    } else if (jenis === 'sholat') {
        countdownDurasi(durasi.sholat[waktuSholat], () => {
            overlay.classList.add('hidden');
        });
    }
}

function countdownDurasi(seconds, callback) {
    clearInterval(overlayTimer);
    let sisa = seconds;
    updateCountdown(sisa);
    overlayTimer = setInterval(() => {
        sisa--;
        updateCountdown(sisa);
        if (sisa <= 0) {
            clearInterval(overlayTimer);
            callback();
        }
    }, 1000);
}

function updateCountdown(s) {
    const m = String(Math.floor(s / 60)).padStart(2, '0');
    const d = String(s % 60).padStart(2, '0');
    countdownOverlay.textContent = `Sisa waktu: ${m}:${d}`;
}

// ========== TRIGGER ADZAN/IQAMAH ==========
let adzanSudahTayang = {};
const waktuAktifOverlay = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

function cekDanTampilkanOverlay() {
    const aktif = getActivePrayer();
    const now = new Date();
    const waktuAktif = parseTime(jadwalSholat[aktif]);

    if (!waktuAktifOverlay.includes(aktif)) return;

    if (!adzanSudahTayang[aktif] && Math.abs((now - waktuAktif) / 1000) < 2) {
        tampilkanOverlay('adzan', aktif);
        mainkanAlarm(0.8);
        adzanSudahTayang[aktif] = true;
    }
}

// ========== NOTIFIKASI KHUSUS ==========
const notifBox = document.getElementById('notifikasi-ringkas');
const isiNotif = document.getElementById('isi-notifikasi');
let notifikasiSudahTayang = {};

function tampilkanNotifikasi(teks, waktu) {
    if (notifikasiSudahTayang[waktu]) return;

    isiNotif.textContent = teks;
    notifBox.classList.remove('hidden');

    mainkanAlarm(0.4); // suara pelan untuk non-wajib

    setTimeout(() => {
        notifBox.classList.add('hidden');
    }, 10000);

    notifikasiSudahTayang[waktu] = true;
}

function cekWaktuNonOverlay() {
    const now = new Date();
    const waktuKhusus = {
        imsak: 'Waktu imsak telah masuk. Selesaikan sahur Anda.',
        syuruq: 'Matahari telah terbit.',
        dhuha: 'Waktu dhuha telah masuk. Ayo sholat sunnah!'
    };

    for (const waktu in waktuKhusus) {
        const target = parseTime(jadwalSholat[waktu]);
        if (!notifikasiSudahTayang[waktu] && Math.abs((now - target) / 1000) < 2) {
            tampilkanNotifikasi(waktuKhusus[waktu], waktu);
        }
    }
}

// ========== MAIN LOOP ==========
setInterval(() => {
    updateJamDigital();
    updateActiveCard();
    cekDanTampilkanOverlay();
    cekWaktuNonOverlay();
}, 1000);
