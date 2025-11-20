// Jadwal sholat dalam format 24 jam (HH:MM)
function parseTime(timeStr) {
    const [h, m, s] = timeStr.split(':').map(Number);
    const now = new Date();

    return new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m, s || 0);
}

// Mendapatkan waktu sholat yang sedang aktif
function getActivePrayer() {
    const keys = ['imsak', 'subuh', 'syuruq', 'dhuha', 'dzuhur', 'ashar', 'maghrib', 'isya'];

    for (let i = 0; i < keys.length; i++) {
        const start = parseTime(jadwalSholat[keys[i]]);
        const end = i < keys.length - 1 ? parseTime(jadwalSholat[keys[i + 1]]) : new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
        if (now >= start && now < end) return keys[i];
    }

    return null;
}