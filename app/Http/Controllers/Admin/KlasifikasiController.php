<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateKlasifikasiRequest;
use App\Models\KlasifikasiBuku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KlasifikasiController extends Controller
{
    public function index(): View
    {
        $classifications = KlasifikasiBuku::query()
            ->withCount('buku')
            ->orderBy('sort_order')
            ->get();

        return view('admin.klasifikasi.index', compact('classifications'));
    }

    public function edit(KlasifikasiBuku $klasifikasi): View
    {
        return view('admin.klasifikasi.edit', compact('klasifikasi'));
    }

    public function update(UpdateKlasifikasiRequest $request, KlasifikasiBuku $klasifikasi): RedirectResponse
    {
        $data = $request->validated();
        $data['keywords'] = collect(preg_split('/[,\r\n]+/', $data['keywords_text']) ?: [])
            ->map(fn (string $keyword): string => trim(Str::lower($keyword)))
            ->filter()
            ->unique()
            ->values()
            ->all();
        $data['is_active'] = $request->boolean('is_active');
        unset($data['keywords_text']);

        $klasifikasi->update($data);

        return to_route('admin.klasifikasi.index')
            ->with('success', 'Kamus klasifikasi berhasil diperbarui.');
    }
}
