<?php

use App\Http\Controllers\Admin\AnggotaController;
// Import semua Controller yang dibutuhkan
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KlasifikasiController;
use App\Http\Controllers\Admin\KontenPublikController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PermintaanPublikController as AdminPermintaanPublikController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PublicCatalogController;
use App\Http\Controllers\PublicExperienceController;
use App\Http\Controllers\TampilanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PERPUSTAKAAN STMI
|--------------------------------------------------------------------------
*/

// --- 0. ROUTE PUBLIK UTAMA ---
Route::get('/', [TampilanController::class, 'index'])->name('home');
Route::get('/katalog', [PublicCatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{buku}', [PublicCatalogController::class, 'show'])->name('catalog.show');
Route::get('/eksplorasi', [PublicExperienceController::class, 'explore'])->name('explore.index');
Route::get('/informasi/{konten}', [PublicExperienceController::class, 'content'])->name('public-content.show');
Route::post('/permintaan-layanan', [PublicExperienceController::class, 'storeRequest'])
    ->middleware('throttle:10,1')
    ->name('public-request.store');
Route::get('/cek-peminjaman', [PublicExperienceController::class, 'loanStatus'])->name('loan-status.index');
Route::post('/cek-peminjaman', [PublicExperienceController::class, 'checkLoanStatus'])
    ->middleware('throttle:10,1')
    ->name('loan-status.check');
Route::get('/media/{path}', [MediaController::class, 'show'])
    ->where('path', '.*')
    ->name('media.show');

// --- 1. ROUTE PUBLIK (Profil & Informasi) ---
Route::prefix('tampilan')->group(function () {
    Route::get('/sejarah', [TampilanController::class, 'sejarah'])->name('tampilan.sejarah');
    Route::get('/visi-misi', [TampilanController::class, 'visiMisi'])->name('tampilan.visi-misi');
    Route::get('/tujuan-fungsi', [TampilanController::class, 'tujuanFungsi'])->name('tampilan.tujuan-fungsi');
    Route::get('/struktur-organisasi', [TampilanController::class, 'strukturOrganisasi'])->name('tampilan.struktur-organisasi');
    Route::get('/peraturan-tata-tertib', [TampilanController::class, 'peraturanTataTertib'])->name('tampilan.peraturan-tata-tertib');
});

// Route Layanan & E-Resources
Route::get('/layanan', [TampilanController::class, 'layanan'])->name('tampilan.layanan');
Route::get('/e-resources', [TampilanController::class, 'eResources'])->name('e-resources');

// --- 2. ROUTE OTENTIKASI ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:login')
        ->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// --- 3. ROUTE ADMIN (Proteksi Middleware Auth) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    // [PERBAIKAN] Diarahkan ke DashboardController agar variabel statistik terkirim ke view
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('anggota', AnggotaController::class)
        ->parameters(['anggota' => 'anggota']);

    Route::get('buku/search', [BukuController::class, 'searchByDocument'])->name('buku.search');
    Route::post('buku/classify', [BukuController::class, 'classify'])->name('buku.classify');
    Route::post('buku/reclassify', [BukuController::class, 'reclassify'])->name('buku.reclassify');
    Route::resource('buku', BukuController::class);

    Route::resource('klasifikasi', KlasifikasiController::class)
        ->parameters(['klasifikasi' => 'klasifikasi'])
        ->only(['index', 'edit', 'update']);

    Route::resource('konten', KontenPublikController::class)
        ->parameters(['konten' => 'konten'])
        ->except(['show']);

    Route::resource('permintaan', AdminPermintaanPublikController::class)
        ->parameters(['permintaan' => 'permintaan'])
        ->only(['index', 'show', 'update', 'destroy']);

    // Transaksi Peminjaman
    Route::resource('peminjaman', PeminjamanController::class)
        ->only(['index', 'create', 'store', 'show', 'edit']);

    Route::post('peminjaman/{peminjaman}/pengembalian', [PeminjamanController::class, 'returnItems'])
        ->name('peminjaman.return-items');
    Route::post('peminjaman/send-reminders', [PeminjamanController::class, 'sendReminders'])
        ->name('peminjaman.send-reminders');
});
