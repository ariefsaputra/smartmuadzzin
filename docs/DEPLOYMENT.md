# Deployment

## Runtime

Gunakan PHP 8.1 atau lebih baru untuk web server, CLI, Composer, Spark, dan
PHPUnit. Laragon pada mesin ini sudah memilih PHP 8.4 untuk web server; CLI
harus menunjuk ke versi yang sama atau versi 8.1+.

Verifikasi dengan `php -v`, lalu jalankan `php spark routes` dan
`php vendor/bin/phpunit`.

## Environment

Salin `env` menjadi `.env`, lalu isi `app.baseURL`, pengaturan database,
`admin.username`, `admin.passwordHash`, dan `sync.token`. Jangan commit `.env`.

## Offline-first

Seluruh aset frontend aktif berada secara lokal. Pengaturan kota dapat diisi
manual agar administrasi tetap dapat dilakukan saat internet tidak tersedia.
Gunakan kode kota MyQuran dan nama kota yang sesuai.
