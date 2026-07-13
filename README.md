# Perpustakaan STMI

Sistem administrasi perpustakaan Politeknik STMI Jakarta berbasis Laravel 12. Aplikasi mencakup pengelolaan anggota dan katalog, peminjaman, pengembalian per item, serta dashboard sirkulasi.

## Kebutuhan

- PHP 8.2 atau lebih baru
- Composer 2
- MySQL 8 atau MariaDB yang kompatibel
- Node.js hanya diperlukan jika aset front-end dikembangkan lebih lanjut

## Menjalankan Lokal

1. Salin .env.example menjadi .env, lalu isi koneksi database MySQL.
2. Jalankan composer install.
3. Jalankan php artisan key:generate.
4. Jalankan php artisan migrate --seed.
5. Jalankan php artisan serve.

Seeder pada lingkungan local dan testing membuat akun administrator bila belum ada:

- Email: local-admin@perpustakaan.test
- Password: password
- Form login menerima ID numerik atau email administrator.

Ubah password akun ini sebelum dipakai di lingkungan selain lokal.

## Portfolio Deploy

Panduan singkat untuk mode portfolio ada di [DEPLOY_PORTFOLIO.md](DEPLOY_PORTFOLIO.md).

Stack yang paling ringan untuk pamer hasil:

- Hosting aplikasi: Vercel
- Database gratis: Supabase Postgres
- File upload opsional: storage cloud eksternal

## Perintah Pengembangan

    composer test
    composer lint
    php artisan view:cache

Test memakai database terpisah bernama perpustakaan_testing. Buat sekali pada MySQL lokal:

    CREATE DATABASE perpustakaan_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

## Aturan Stok

- jumlah_dokumen adalah jumlah total eksemplar yang dimiliki.
- jumlah_tersedia adalah eksemplar yang saat ini dapat dipinjam.
- Peminjaman dan pengembalian berjalan dalam transaksi database dengan row lock untuk mencegah stok negatif atau pengembalian ganda.
- Koleksi dan anggota yang memiliki riwayat peminjaman tidak dapat dihapus.
- Lama pinjam, jumlah judul maksimal, dan denda harian dapat diatur melalui LIBRARY_LOAN_DURATION_DAYS, LIBRARY_LOAN_MAX_ITEMS, dan LIBRARY_LATE_FEE_PER_DAY.

## Catatan Upgrade

Migrasi 2026_07_13_000000_modernize_library_domain mengonversi stok dari versi lama, menambahkan tanggal pengembalian per item, meng-hash password lama yang masih plaintext, serta menjaga riwayat transaksi dengan foreign key restriktif.

Sebelum deployment produksi, set minimal:

    APP_ENV=production
    APP_DEBUG=false
    APP_TIMEZONE=Asia/Jakarta
