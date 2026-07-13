<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePermintaanPublikRequest;
use App\Models\PermintaanPublik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermintaanPublikController extends Controller
{
    public function index(Request $request): View
    {
        $type = trim((string) $request->query('type', ''));
        $status = trim((string) $request->query('status', ''));

        $requests = PermintaanPublik::query()
            ->when(isset(PermintaanPublik::TYPES[$type]), fn ($query) => $query->where('type', $type))
            ->when(isset(PermintaanPublik::STATUSES[$status]), fn ($query) => $query->where('status', $status))
            ->orderByRaw("case when status = 'baru' then 0 when status = 'diproses' then 1 else 2 end")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statusCounts = PermintaanPublik::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.permintaan.index', compact('requests', 'type', 'status', 'statusCounts'));
    }

    public function show(PermintaanPublik $permintaan): View
    {
        $permintaan->load('handler');

        return view('admin.permintaan.show', compact('permintaan'));
    }

    public function update(UpdatePermintaanPublikRequest $request, PermintaanPublik $permintaan): RedirectResponse
    {
        $data = $request->validated();
        $data['handled_by'] = $request->user()->getKey();
        $data['handled_at'] = $data['status'] === 'baru' ? null : now();
        $permintaan->update($data);

        return back()->with('success', 'Status permintaan berhasil diperbarui.');
    }

    public function destroy(PermintaanPublik $permintaan): RedirectResponse
    {
        $permintaan->delete();

        return to_route('admin.permintaan.index')->with('success', 'Permintaan berhasil dihapus.');
    }
}
