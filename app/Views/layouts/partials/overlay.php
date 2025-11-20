<?php
/*
 * Overlay Partial View
 *
 * Bagian ini berfungsi untuk menampilkan overlay pada tv informasi Masjid.
 * 1. Countdown 15 menit sebelum adzan dan menampilkan tulisan "Menjelang Adzan Sholat [Waktu Sholat].
 * 2. Countdown 4 menit waktu Adzan.
 * 3. Countdown menjelang iqamah
 * 4. Menampilkan tulisan "Waktu Sholat" dan tulisan besar "HARAP TENANG"
 * 5. setiap durasi diambil ke database
 * 
 */
?>
<!-- Overlay Sebelum Adzan, Adzan Menjelang, Iqamah,& Sholat -->
<!-- Overlay Container dengan warna background gradient yang cerah -->

<div id="overlay-container" class="fixed inset-0 bg-gradient-to-br from-gray-900 via-violet-900 to-fuchsia-900 bg-opacity-90 backdrop-blur-sm flex flex-col justify-center items-center text-center z-50 p-6 space-y-8 hidden">
    
    <!-- Container Widget Jam Analog Overlay -->
    <div id="overlay-jam-digital" class="bg-white/70 backdrop-blur-sm rounded-xl shadow-lg px-2 py-2 border border-gray-500/40 inline-block">
        <div id="jam-digital-overlay" class="text-2xl font-bold tracking-widest flex items-center gap-2">
            <!-- Tanggal Masehi -->
            <span id="overlay-tanggal-masehi"></span>
            
            <!-- Jam Digital Overlay -->
            <span id="overlay-icon-jam">&nbsp;&nbsp;</span>
            <span id="overlay-jam">00</span>
            <span id="overlay-separator">:</span>
            <span id="overlay-menit">00</span>
            <span id="overlay-separator-detik">:</span>
            <span id="overlay-detik-satuan">00</span>
        </div>
    </div>

    <!-- Kondisi Overlay akan diatur melalui JavaScript berdasarkan waktu sholat -->
    <div id="overlay-waktu-Sholat">
        <h1 id="overlay-judul" class="text-7xl font-extrabold mb-6 text-white drop-shadow-lg">Judul</h1>
        <div class="font-extrabold text-fuchsia-200 drop-shadow-lg">
            <span class="text-8xl animate-pulse hidden" id="overlay-deskripsi">KETERANGAN OVERLAY</span>
            <span id="overlay-countdown" class="text-9xl hidden">00:00</span>
        </div>
    </div>

</div>
<!-- End of Overlay Sebelum Adzan, Adzan Menjelang, Iqamah,& Sholat -->

<script>
    // Inisialisasi waktu sekarang untuk overlay
    
    
    // tanggal Masehi Overlay
    function updateOverlayDate() {
        const overlay_now = new Date();
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const tanggalMasehi = overlay_now.toLocaleDateString('id-ID', options);
        document.getElementById('overlay-tanggal-masehi').textContent = tanggalMasehi;
    }

    // Jam Digital Overlay
    function updateOverlayClock() {
        const overlay_now = new Date();

        const overlay_hours = String(overlay_now.getHours()).padStart(2, '0');
        const overlay_minutes = String(overlay_now.getMinutes()).padStart(2, '0');
        const overlay_seconds = String(overlay_now.getSeconds()).padStart(2, '0');

        document.getElementById('overlay-jam').textContent = overlay_hours;
        document.getElementById('overlay-menit').textContent = overlay_minutes;
        document.getElementById('overlay-detik-satuan').textContent = overlay_seconds;
    }
    // Memperbarui tanggal dan jam setiap detik
    setInterval(updateOverlayDate, 1000);
    updateOverlayDate();

    setInterval(updateOverlayClock, 1000);
    updateOverlayClock();
</script>
