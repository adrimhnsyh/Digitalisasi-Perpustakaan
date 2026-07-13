<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KlasifikasiBuku;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $classification = $request->integer('classification');
        $type = trim((string) $request->query('type', ''));
        $availability = trim((string) $request->query('availability', ''));

        $books = Buku::query()
            ->with('klasifikasi')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('subyek', 'like', "%{$search}%")
                        ->orWhere('abstrak', 'like', "%{$search}%")
                        ->orWhere('kode_panggil', 'like', "%{$search}%");
                });
            })
            ->when($classification > 0, fn ($query) => $query->where('klasifikasi_id', $classification))
            ->when(in_array($type, ['Buku', 'Jurnal', 'Tugas Akhir'], true), fn ($query) => $query->where('kategori', $type))
            ->when($availability === 'available', fn ($query) => $query->available())
            ->when($availability === 'borrowed', fn ($query) => $query->where('jumlah_tersedia', 0))
            ->orderByDesc('is_featured')
            ->orderByDesc('is_recommended')
            ->orderBy('judul')
            ->paginate(12)
            ->withQueryString();

        $classifications = KlasifikasiBuku::query()
            ->active()
            ->withCount('buku')
            ->orderBy('sort_order')
            ->get();

        return view('catalog.index', compact(
            'books',
            'classifications',
            'search',
            'classification',
            'type',
            'availability',
        ));
    }

    public function show(Buku $buku): View
    {
        $buku->load('klasifikasi');

        $relatedBooks = Buku::query()
            ->with('klasifikasi')
            ->whereKeyNot($buku->getKey())
            ->when($buku->klasifikasi_id, fn ($query) => $query->where('klasifikasi_id', $buku->klasifikasi_id))
            ->take(4)
            ->get();

        return view('catalog.show', compact('buku', 'relatedBooks'));
    }
}
