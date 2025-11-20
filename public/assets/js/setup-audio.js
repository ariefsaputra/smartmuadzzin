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