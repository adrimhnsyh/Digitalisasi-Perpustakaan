# Deploy Portfolio

Panduan ini ditulis untuk mode "portfolio dulu", jadi targetnya aplikasi bisa online dan ada URL yang bisa dipamerkan, bukan infrastruktur produksi penuh.

## Rekomendasi Stack

- App: Vercel
- Database: Supabase Postgres
- File upload: sebaiknya storage cloud eksternal

Catatan penting:

- Project ini memakai upload file buku dan konten.
- Jika tetap deploy ke Vercel tanpa storage cloud, file yang diunggah dari admin bisa tidak persisten.
- Untuk demo portfolio, itu masih bisa diterima selama Anda tahu batasannya.

## 1. Push ke Git

Setelah repo lokal siap:

```bash
git add .
git commit -m "Initial portfolio-ready setup"
```

Lalu buat repository GitHub dan sambungkan:

```bash
git remote add origin <URL_REPOSITORY_ANDA>
git branch -M main
git push -u origin main
```

## 2. Buat Database Supabase

Di Supabase:

1. Buat project baru.
2. Buka menu database dan ambil kredensial PostgreSQL.
3. Simpan nilai berikut:
   - host
   - port
   - database
   - username
   - password

## 3. Environment Variables untuk Vercel

Masukkan environment variables berikut di project Vercel Anda:

```env
APP_NAME="Perpustakaan STMI"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://nama-project-anda.vercel.app
ASSET_URL=
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
APP_FAKER_LOCALE=id_ID

APP_KEY=

LOG_CHANNEL=stderr
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_SCHEMA=public
DB_SSLMODE=require
DATABASE_URL=

LIBRARY_LOAN_DURATION_DAYS=7
LIBRARY_LOAN_MAX_ITEMS=2
LIBRARY_LATE_FEE_PER_DAY=1000

CACHE_DRIVER=array
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=true
```

Catatan:

- `APP_KEY` wajib diisi dari hasil `php artisan key:generate --show`.
- `SESSION_DRIVER=cookie` lebih cocok untuk deploy serverless ringan.
- `CACHE_DRIVER=array` dipilih supaya tidak bergantung pada filesystem persisten.
- Untuk Supabase, biasanya koneksi PostgreSQL production lebih aman memakai `DB_SSLMODE=require`.
- Anda bisa mengisi `DATABASE_URL` atau pasangan `DB_HOST`/`DB_PORT`/`DB_DATABASE`/`DB_USERNAME`/`DB_PASSWORD`. Di project ini keduanya didukung.
- Jika nanti Anda memakai storage cloud, ganti `FILESYSTEM_DISK` dari `local` ke disk cloud yang Anda konfigurasi.
- File contoh siap pakai juga sudah ada di [.env.supabase.example](.env.supabase.example).
- File [vercel.json](vercel.json), [.vercelignore](.vercelignore), dan [api/index.php](api/index.php) sudah disiapkan untuk entrypoint Laravel di Vercel.

## 4. Migrasi Database

Setelah env produksi siap, jalankan migrasi ke database Supabase Anda dari lokal:

```bash
php artisan migrate --force
php artisan db:seed --force
```

Pastikan `.env` lokal Anda sementara diarahkan ke database Supabase saat menjalankan dua perintah ini.

Jika ingin aman, buat file `.env.supabase` terpisah di lokal berisi kredensial production Supabase, lalu jalankan:

```bash
php artisan migrate --force --env=supabase
php artisan db:seed --force --env=supabase
```

Kalau Anda memilih cara ini, jangan commit file `.env.supabase`.

## 5. Langkah di Vercel

Saat import repo GitHub ke Vercel:

1. Pilih repository ini.
2. Tambahkan seluruh environment variables di atas sebelum deploy pertama.
3. Isi `APP_KEY` terlebih dahulu.
4. Deploy akan memakai runtime `vercel-php@0.7.4` dari `vercel-community/php`.
5. Setelah deploy berhasil, cek halaman utama dan login admin.

Kalau deploy pertama gagal, biasanya titik masalahnya ada di runtime PHP Vercel atau env database yang belum lengkap. Dalam kasus itu, periksa log deploy dulu sebelum mengubah kode aplikasi.

## 6. Login Demo

Seeder lokal/testing membuat akun admin:

- Email: `local-admin@perpustakaan.test`
- Password: `password`

Untuk portfolio, sebaiknya buat akun admin baru setelah deploy dan ganti password default.

## 7. Batasan yang Perlu Anda Tahu

- Tanpa storage cloud, upload cover/gambar/lampiran dari admin tidak cocok untuk jangka panjang.
- Pada konfigurasi Vercel saat ini, file upload akan diarahkan ke `/tmp` supaya request tidak langsung gagal, tetapi tetap tidak persisten antar instance.
- Karena ini targetnya portfolio, Anda masih bisa deploy dulu untuk menunjukkan UI, katalog, dashboard, dan alur login.
- Jika nanti ingin lebih stabil, langkah upgrade paling masuk akal adalah pindah storage file ke cloud dan/atau pindah hosting app ke Render atau Railway.
