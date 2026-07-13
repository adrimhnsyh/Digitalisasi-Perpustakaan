<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckLoanStatusRequest;
use App\Http\Requests\StorePermintaanPublikRequest;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\KlasifikasiBuku;
use App\Models\KontenPublik;
use App\Models\Peminjaman;
use App\Models\PermintaanPublik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicExperienceController extends Controller
{
    public function explore(): View
    {
        $classifications = KlasifikasiBuku::query()
            ->active()
            ->withCount('buku')
            ->orderBy('sort_order')
            ->get();

        $content = KontenPublik::query()
            ->published()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('type');

        $staffPicks = Buku::query()
            ->with('klasifikasi')
            ->recommended()
            ->latest('updated_at')
            ->take(5)
            ->get();

        $mostPopular = Buku::query()
            ->with('klasifikasi')
            ->withSum('detailPeminjaman as total_dipinjam', 'jumlah_pinjam')
            ->orderByDesc('total_dipinjam')
            ->first();

        $wrapped = [
            'collections' => Buku::query()->count(),
            'available' => (int) Buku::query()->sum('jumlah_tersedia'),
            'loans_this_year' => Peminjaman::query()->whereYear('tanggal_pinjam', now()->year)->count(),
            'items_this_year' => (int) DetailPeminjaman::query()
                ->whereHas('peminjaman', fn ($query) => $query->whereYear('tanggal_pinjam', now()->year))
                ->sum('jumlah_pinjam'),
        ];

        $gallery = collect(range(1, 8))->map(fn (int $index): array => [
            'src' => asset("images/ISI PERPUS ({$index}).jpg"),
            'alt' => "Suasana dan fasilitas perpustakaan {$index}",
        ]);

        return view('explore.index', compact(
            'classifications',
            'content',
            'staffPicks',
            'mostPopular',
            'wrapped',
            'gallery',
        ));
    }

    public function content(KontenPublik $konten): View
    {
        abort_unless(
            $konten->is_published && (! $konten->published_at || $konten->published_at->isPast()),
            404,
        );

        $relatedContent = KontenPublik::query()
            ->published()
            ->where('type', $konten->type)
            ->whereKeyNot($konten->getKey())
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('explore.content', compact('konten', 'relatedContent'));
    }

    public function storeRequest(StorePermintaanPublikRequest $request): RedirectResponse
    {
        PermintaanPublik::create($request->validated());

        return back()->with('request_success', 'Pesan Anda sudah diterima dan akan ditinjau oleh tim perpustakaan.');
    }

    public function loanStatus(): View
    {
        return view('loan-status.index', ['member' => null, 'loans' => collect()]);
    }

    public function checkLoanStatus(CheckLoanStatusRequest $request): View|RedirectResponse
    {
        $data = $request->validated();
        $member = Anggota::query()->where('no_identitas', $data['no_identitas'])->first();
        $phoneDigits = $member ? preg_replace('/\D+/', '', $member->no_telp) : '';

        if (! $member || ! Str::endsWith((string) $phoneDigits, $data['phone_last_four'])) {
            return back()
                ->withInput($request->only('no_identitas'))
                ->withErrors(['no_identitas' => 'Data anggota tidak cocok. Periksa nomor identitas dan empat digit telepon.']);
        }

        $loans = $member->peminjaman()
            ->with('detailPeminjaman.buku.klasifikasi')
            ->latest('tanggal_pinjam')
            ->take(25)
            ->get();

        return view('loan-status.index', compact('member', 'loans'));
    }
}
