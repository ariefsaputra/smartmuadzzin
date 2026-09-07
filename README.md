# 🕌 SmartMuadzzin

**SmartMuadzzin** adalah aplikasi **TV Informasi Masjid** dan **Sistem Manajemen Jadwal Sholat** berbasis web yang dirancang dengan prinsip **OFFLINE-FIRST**, stabil, dan ringan.  
Aplikasi ini ditujukan untuk lingkungan masjid, musholla, dan fasilitas dakwah yang membutuhkan sistem informasi **24/7**, bahkan tanpa koneksi internet.

---

## 🎯 Tujuan Aplikasi

- Menampilkan **jadwal sholat otomatis**
- Menyediakan **TV Informasi Masjid**
- Menampilkan **running text / pengumuman**
- Menampilkan **media slider (gambar masjid / kegiatan)**
- Tetap berjalan **normal meskipun internet mati**

---

## ✨ Fitur Utama

### 🕋 Tampilan TV Masjid
- Jadwal sholat harian (highlight waktu aktif)
- Countdown menuju adzan & iqamah
- Overlay adzan & iqamah
- Jam digital real-time
- Slider gambar masjid / kegiatan
- Running text pengumuman

### 🛠️ Admin Dashboard
- Kelola informasi masjid
- Kelola jadwal sholat
- Kelola media slider
- Kelola pengumuman / running text
- Pengaturan sistem terpusat

### 🌐 Offline-First Architecture
- Tanpa ketergantungan CDN
- Asset frontend sepenuhnya lokal
- Data utama disimpan di database lokal
- API hanya digunakan untuk **sinkronisasi**, bukan runtime

---

## 🧱 Teknologi yang Digunakan

### Backend
- **PHP 8+**
- **CodeIgniter 4**

### Frontend
- **Tailwind CSS (local build)**
- **Alpine.js (local)**
- **Phosphor Icons (local)**

### Database
- MySQL / MariaDB / SQLite

### Deployment
- PC lokal
- Raspberry Pi
- Mini PC (Chromium Kiosk Mode)

---

## 📁 Struktur Direktori (Ringkas)

app/
├─ Controllers/
├─ Models/
├─ Views/

public/
├─ assets/
│ ├─ css/
│ ├─ js/
│ ├─ icons/
│ └─ images/
└─ index.php

---

## ⚙️ Instalasi

### 1️⃣ Clone Repository
git clone https://github.com/username/smartmuadzzin.git
cd smartmuadzzin

### 2️⃣ Install Dependency
composer install

### 3️⃣ Konfigurasi Environment
cp env .env

Edit .env:

CI_ENVIRONMENT = production
app.baseURL = 'http://localhost:8080/'
database.default.database = smartmuadzzin

### 4️⃣ Jalankan Aplikasi
php spark serve

Akses:

Admin: http://localhost:8080/admin

TV Display: http://localhost:8080

### Deployment Check

Pastikan perintah `php -v` menunjukkan PHP 8.1 atau lebih baru sebelum menjalankan Composer, Spark, atau PHPUnit. Panduan deployment tersedia di `docs/DEPLOYMENT.md`.

### 📡 Mode Online vs Offline
- Kondisi	Perilaku
- Online	Sinkronisasi jadwal sholat via API
- Offline	Gunakan data lokal
- Internet mati	Sistem tetap berjalan normal
- Restart listrik	Aman, data tidak hilang

### 🧪 Rekomendasi Testing

Chromium (kiosk mode)
Raspberry Pi OS
Monitor TV ≥ 32”
Resolusi Full HD

### 🔐 Keamanan & Stabilitas

Tidak ada registrasi publik
Akses admin dibatasi
Tidak bergantung pada layanan eksternal saat runtime
Cocok untuk operasional jangka panjang

### 🚀 Roadmap (Opsional)

PWA Mode
Auto fallback API
Remote sync dashboard
Installer Raspberry Pi Image
Notifikasi status online/offline

### 🤝 Kontribusi

Kontribusi sangat terbuka, terutama pada:

- Optimasi performa
- UI/UX TV Display
- Sinkronisasi jadwal sholat
- Dokumentasi

Silakan buat Pull Request atau Issue.

### 📄 Lisensi

SmartMuadzzin dirilis di bawah lisensi MIT.
Bebas digunakan, dimodifikasi, dan dikembangkan untuk keperluan dakwah dan sosial.

### 🙏 Penutup

SmartMuadzzin dikembangkan dengan tujuan menghadirkan teknologi yang sederhana, bermanfaat, dan andal untuk mendukung aktivitas masjid dan dakwah.

“Masjid modern tidak harus bergantung pada internet.”
