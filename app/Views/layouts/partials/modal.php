<!-- Modal Partial View -->
<?php
/*
 * Modal Partial View
 *
 * Bagian ini berfungsi untuk menampilkan modal pada tv informasi Masjid.
 * Modal ini digunakan untuk menampilkan informasi selain waktu sholat,
 * seperti telah masuk Imsyak, Syuruq, Dhuha, dan lain-lain.
 * Modal ini dapat diatur tampilannya melalui JavaScript.
 * 1. Modal akan muncul di tengah layar dengan latar belakang dengan warna cerah blur transparan 30%.
 * 2. Modal dapat ditutup dengan otomatis setelah 1 menit.
 * 3. Durasi selain waktu sholat adalah 1 menit.
 * 4. Tambahkan tampilan countdown di dalam modal.
 * 5. Penamaan modal disesuaikan dengan prefiks "modal-non-waktu-sholat"
 * 6. Huruf pada judul dan deskripsi serta countdown menggunakan font yang tebal dan besar dan cerah serta warna yang cerah.
 * 7. Warna modal warna kontras.
 * 8. Judul buat lebih besar dari deskripsi dan countdown.
 */
?>
<!-- Modal Non Waktu Sholat -->
<div id="modal-non-waktu-sholat" class="fixed inset-0 bg-opacity-10 backdrop-blur-sm flex justify-center items-center z-50 hidden">
    <div class="bg-gray-800 rounded-lg shadow-lg p-8 max-w-lg w-full text-center relative border-4 border-yellow-400">
        <!-- Judul Modal -->
        <h2 id="modal-judul" class="text-4xl font-extrabold mb-4 text-yellow-300 drop-shadow-lg">Judul Modal</h2>
        
        <!-- Deskripsi Modal -->
        <p id="modal-deskripsi" class="text-xl mb-6 text-white drop-shadow-lg">Deskripsi atau informasi tambahan dapat ditampilkan di sini.</p>
        
        <!-- Countdown Timer -->
        <div class="text-6xl font-extrabold text-red-600 drop-shadow-lg" id="modal-countdown"></div>
    </div>
</div>
<!-- End of Modal Non Waktu Sholat -->