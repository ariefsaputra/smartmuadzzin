# Artefak lama

Rute aplikasi saat ini hanya memakai `Tv::index`, dashboard admin, dan view
yang dipanggil oleh controller tersebut. Berkas di bawah masih dipertahankan
sebagai referensi historis dan tidak boleh dihubungkan ke rute baru tanpa audit:

- `app/Views/display/`
- `app/Views/layouts/`
- `app/Views/admin/index.php`
- `app/Views/admin/jadwal_form.php`
- `app/Views/admin/media_form.php`
- `app/Controllers/Home.php`
- `app/Models/PosterModel.php` dan `app/Models/SliderModel.php`

`app/Views/tv_main_old.php` adalah berkas kerja lokal yang tidak dilacak Git;
berkas tersebut sengaja tidak dipindahkan atau dihapus oleh perubahan ini.
