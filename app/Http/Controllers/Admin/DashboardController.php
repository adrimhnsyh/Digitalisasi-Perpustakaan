<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KontenPublik;
use App\Models\Peminjaman;
use App\Models\PermintaanPublik;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalBuku = Buku::query()->where('kategori', 'Buku')->count();
        $totalJurnal = Buku::query()->where('kategori', 'Jurnal')->count();
        $totalTugasAkhir = Buku::query()->where('kategori', 'Tugas Akhir')->count();
        $totalEksemplar = (int) Buku::query()->sum('jumlah_dokumen');
        $totalTersedia = (int) Buku::query()->sum('jumlah_tersedia');
        $peminjamanAktif = Peminjaman::query()
            ->whereHas('detailPeminjaman', fn ($query) => $query->where('status_item', 'Dipinjam'))
            ->count();
        $peminjamanTerlambat = Peminjaman::query()
            ->whereDate('tanggal_kembali', '<', today())
            ->whereHas('detailPeminjaman', fn ($query) => $query->where('status_item', 'Dipinjam'))
            ->count();
        $aktivitasTerbaru = Peminjaman::query()
            ->with(['anggota', 'detailPeminjaman.buku'])
            ->latest('id_peminjaman')
            ->take(6)
            ->get();
        $permintaanBaru = PermintaanPublik::query()->where('status', 'baru')->count();
        $kontenDraft = KontenPublik::query()->where('is_published', false)->count();
        $koleksiBelumDiklasifikasi = Buku::query()
            ->where(function ($query): void {
                $query->whereNull('classification_source')
                    ->orWhereIn('classification_source', ['legacy']);
            })
            ->count();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalJurnal',
            'totalTugasAkhir',
            'totalEksemplar',
            'totalTersedia',
            'peminjamanAktif',
            'peminjamanTerlambat',
            'aktivitasTerbaru',
            'permintaanBaru',
            'kontenDraft',
            'koleksiBelumDiklasifikasi',
        ));
    }
}
