<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertBukuRequest;
use App\Models\Buku;
use App\Models\KlasifikasiBuku;
use App\Services\BookClassificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function __construct(private readonly BookClassificationService $classificationService) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $classification = $request->integer('classification');
        $documentType = trim((string) $request->query('type', ''));

        $buku = Buku::query()
            ->with('klasifikasi')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('kode_panggil', 'like', "%{$search}%")
                        ->orWhere('subyek', 'like', "%{$search}%")
                        ->orWhere('abstrak', 'like', "%{$search}%")
                        ->orWhere('no_document', 'like', "%{$search}%");
                });
            })
            ->when($classification > 0, fn ($query) => $query->where('klasifikasi_id', $classification))
            ->when(in_array($documentType, ['Buku', 'Jurnal', 'Tugas Akhir'], true), fn ($query) => $query->where('kategori', $documentType))
            ->orderByDesc('no_document')
            ->paginate(10)
            ->withQueryString();

        $classifications = KlasifikasiBuku::query()->orderBy('sort_order')->get();

        return view('admin.buku.index', compact(
            'buku',
            'search',
            'classification',
            'documentType',
            'classifications',
        ));
    }

    public function create(): View
    {
        $classifications = KlasifikasiBuku::query()->active()->orderBy('sort_order')->get();

        return view('admin.buku.create', compact('classifications'));
    }

    public function store(UpsertBukuRequest $request): RedirectResponse
    {
        $data = $this->prepareBookData($request);
        $data['jumlah_tersedia'] = $data['jumlah_dokumen'];

        $buku = Buku::create($data);
        $this->keepSingleFeaturedBook($buku);

        return to_route('admin.buku.show', $buku)
            ->with('success', 'Koleksi buku berhasil ditambahkan.');
    }

    public function show(Buku $buku): View
    {
        $buku->load('klasifikasi');

        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku): View
    {
        $classifications = KlasifikasiBuku::query()->active()->orderBy('sort_order')->get();

        return view('admin.buku.edit', compact('buku', 'classifications'));
    }

    public function update(UpsertBukuRequest $request, Buku $buku): RedirectResponse
    {
        $data = $this->prepareBookData($request, $buku);
        $jumlahDipinjam = (int) $buku->detailPeminjaman()
            ->where('status_item', 'Dipinjam')
            ->sum('jumlah_pinjam');

        if ($data['jumlah_dokumen'] < $jumlahDipinjam) {
            throw ValidationException::withMessages([
                'jumlah_dokumen' => "Total stok tidak boleh lebih kecil dari {$jumlahDipinjam} eksemplar yang masih dipinjam.",
            ]);
        }

        $data['jumlah_tersedia'] = $data['jumlah_dokumen'] - $jumlahDipinjam;
        $buku->update($data);
        $this->keepSingleFeaturedBook($buku);

        return to_route('admin.buku.index')
            ->with('success', 'Data koleksi berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        if ($buku->detailPeminjaman()->exists()) {
            return back()->with('error', 'Koleksi yang memiliki riwayat peminjaman tidak dapat dihapus.');
        }

        if ($buku->cover_image && ! str_starts_with($buku->cover_image, 'images/')) {
            Storage::disk('public')->delete($buku->cover_image);
        }

        $buku->delete();

        return to_route('admin.buku.index')
            ->with('success', 'Koleksi berhasil dihapus.');
    }

    public function searchByDocument(Request $request): JsonResponse
    {
        $data = $request->validate([
            'no_document' => ['required', 'integer'],
        ]);

        $buku = Buku::query()
            ->select(['no_document', 'judul', 'penulis', 'jumlah_tersedia', 'klasifikasi_id'])
            ->with('klasifikasi:id,nama,kode')
            ->find($data['no_document']);

        if (! $buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        if ($buku->jumlah_tersedia < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok buku sedang habis.',
            ], 409);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'no_document' => $buku->no_document,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'jumlah_tersedia' => $buku->jumlah_tersedia,
                'klasifikasi' => $buku->klasifikasi?->nama,
            ],
        ]);
    }

    public function classify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'abstrak' => ['required', 'string', 'min:40', 'max:20000'],
            'subyek' => ['nullable', 'string', 'max:255'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->classificationService->preview(
                $data['judul'],
                $data['abstrak'],
                $data['subyek'] ?? '',
            ),
        ]);
    }

    public function reclassify(): RedirectResponse
    {
        $updated = 0;

        Buku::query()
            ->whereNotNull('abstrak')
            ->where('abstrak', '!=', '')
            ->orderBy('no_document')
            ->each(function (Buku $buku) use (&$updated): void {
                $buku->update($this->classificationService->classify($buku->only([
                    'judul',
                    'abstrak',
                    'subyek',
                ])));
                $updated++;
            });

        return back()->with('success', "{$updated} koleksi berhasil dianalisis ulang.");
    }

    /**
     * @return array<string, mixed>
     */
    private function prepareBookData(UpsertBukuRequest $request, ?Buku $buku = null): array
    {
        $data = $request->validated();
        $mode = $data['classification_mode'] ?? 'auto';
        $removeCover = (bool) ($data['remove_cover'] ?? false);

        unset($data['classification_mode'], $data['cover'], $data['remove_cover']);

        $data['is_recommended'] = $request->boolean('is_recommended');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover')) {
            if ($buku?->cover_image && ! str_starts_with($buku->cover_image, 'images/')) {
                Storage::disk('public')->delete($buku->cover_image);
            }
            $data['cover_image'] = $request->file('cover')->store('books', 'public');
        } elseif ($removeCover && $buku?->cover_image) {
            if (! str_starts_with($buku->cover_image, 'images/')) {
                Storage::disk('public')->delete($buku->cover_image);
            }
            $data['cover_image'] = null;
        }

        if ($mode === 'manual') {
            $data['classification_source'] = 'manual';
            $data['classification_score'] = null;
            $data['classification_keywords'] = [];
        } else {
            $classificationInput = array_merge(
                $buku?->only(['judul', 'abstrak', 'subyek']) ?? [],
                $data,
            );
            $data = array_merge($data, $this->classificationService->classify($classificationInput));
        }

        return $data;
    }

    private function keepSingleFeaturedBook(Buku $buku): void
    {
        if (! $buku->is_featured) {
            return;
        }

        Buku::query()
            ->whereKeyNot($buku->getKey())
            ->where('is_featured', true)
            ->update(['is_featured' => false]);
    }
}
