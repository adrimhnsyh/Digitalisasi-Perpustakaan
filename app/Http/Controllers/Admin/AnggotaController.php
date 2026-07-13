<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertAnggotaRequest;
use App\Models\Anggota;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function index(): View
    {
        $anggota = Anggota::query()
            ->orderByDesc('no_anggota')
            ->paginate(10);

        return view('admin.anggota.index', compact('anggota'));
    }

    public function create(): View
    {
        return view('admin.anggota.create');
    }

    public function store(UpsertAnggotaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['reminder_opt_in'] = $request->boolean('reminder_opt_in');
        Anggota::create($data);

        return to_route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function show(Anggota $anggota): View
    {
        $anggota->load(['peminjaman.detailPeminjaman.buku']);

        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota): View
    {
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(UpsertAnggotaRequest $request, Anggota $anggota): RedirectResponse
    {
        $data = $request->validated();
        $data['reminder_opt_in'] = $request->boolean('reminder_opt_in');
        $anggota->update($data);

        return to_route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota): RedirectResponse
    {
        if ($anggota->peminjaman()->exists()) {
            return back()->with('error', 'Anggota dengan riwayat peminjaman tidak dapat dihapus.');
        }

        $anggota->delete();

        return to_route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
