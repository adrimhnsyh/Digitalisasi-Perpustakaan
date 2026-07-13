<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\KlasifikasiBuku;
use App\Models\KontenPublik;
use Illuminate\View\View;

class TampilanController extends Controller
{
    /**
     * Halaman Home utama.
     */
    public function index(): View
    {
        $stats = [
            'titles' => Buku::query()->count(),
            'copies' => (int) Buku::query()->sum('jumlah_dokumen'),
            'available' => (int) Buku::query()->sum('jumlah_tersedia'),
            'members' => Anggota::query()->where('status', '!=', 'Non Aktif')->count(),
        ];

        $latestBooks = Buku::query()
            ->with('klasifikasi')
            ->latest('no_document')
            ->take(6)
            ->get();

        $classifications = KlasifikasiBuku::query()
            ->active()
            ->withCount('buku')
            ->orderBy('sort_order')
            ->get();

        $news = KontenPublik::query()
            ->published()
            ->type('berita')
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->take(3)
            ->get();

        $events = KontenPublik::query()
            ->published()
            ->type('agenda')
            ->where(fn ($query) => $query->whereNull('event_at')->orWhere('event_at', '>=', today()))
            ->orderBy('event_at')
            ->take(3)
            ->get();

        return view('welcome', compact(
            'stats',
            'latestBooks',
            'classifications',
            'news',
            'events',
        ));
    }

    /**
     * Merujuk langsung ke folder: resources/views/tampilan/
     */
    public function sejarah(): View
    {
        // Sebelumnya: layout.tampilan.sejarah
        return view('tampilan.sejarah');
    }

    public function visiMisi(): View
    {
        return view('tampilan.visi_misi');
    }

    public function tujuanFungsi(): View
    {
        return view('tampilan.tujuan_fungsi');
    }

    public function strukturOrganisasi(): View
    {
        return view('tampilan.struktur');
    }

    public function peraturanTataTertib(): View
    {
        return view('tampilan.peraturan');
    }

    public function layanan(): View
    {
        return view('tampilan.layanan');
    }

    public function eResources(): View
    {
        return view('tampilan.e-resources');
    }
}
