# Sistem Manajemen Logbook Digital Ruang Server BSI KCP Bandung Kopo

Aplikasi web manajemen logbook digital untuk mencatat, memantau, dan mengelola akses kunjungan tamu (vendor maupun petugas internal) di Ruang Server BSI KCP Bandung Kopo.

## Latar Belakang
- Pencatatan tamu ruang server sebelumnya masih menggunakan buku fisik.
- Risiko kehilangan data logbook atau kerusakan dokumen fisik.
- Pemantauan status dan durasi kunjungan secara real-time belum terdokumentasi secara terpusat.

## Fitur Utama
- **Registrasi Tamu Mandiri (*Self-Service*):** Pencatatan identitas (KTP/SIM), nama lengkap, asal instansi/vendor, nomor telepon, dan tujuan kunjungan.
- **Alur *Check-In* & *Check-Out*:** Verifikasi status kunjungan aktif serta pencatatan waktu masuk dan keluar.
- **Panel Admin & Monitoring *Real-Time*:** Statistik kunjungan, daftar kunjungan harian, pemantauan durasi kunjungan, dan pengelolaan data tamu.
- **Pencarian & Ekspor Laporan:** Pencarian data berdasarkan nama, NIK, atau tanggal serta unduh laporan ke format Excel (`.xlsx`) dan PDF.

## Teknologi yang Digunakan
- **Database:** MySQL
- **Backend & Frontend:** Laravel / PHP dan Bootstrap

## Panduan Instalasi Lokal
1. *Clone* atau salin folder proyek ke direktori lokal (`htdocs` atau folder kerja proyek).
2. Buat database baru di MySQL / phpMyAdmin dengan nama `bsi_logbook_db.
3. Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi database (`DB_DATABASE=bsi_logbook_db`, `DB_USERNAME`, dan `DB_PASSWORD`).
4. Install *dependencies* proyek (misalnya `composer install` dan `npm install && npm run build` jika menggunakan Laravel).
5. Generate *application key* (`php artisan key:generate`) dan jalankan migrasi/seeder database (`php artisan migrate`).
6. Jalankan server lokal dan buka aplikasi di browser.

