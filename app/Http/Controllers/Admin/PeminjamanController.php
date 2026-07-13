<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnPeminjamanRequest;
use App\Http\Requests\StorePeminjamanRequest;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Services\LoanReminderService;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $peminjaman = Peminjaman::query()
            ->with(['anggota', 'detailPeminjaman'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('id_peminjaman', 'like', "%{$search}%")
                        ->orWhereHas('anggota', function ($query) use ($search): void {
                            $query->where('nama', 'like', "%{$search}%")
                                ->orWhere('no_anggota', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('tanggal_pinjam')
            ->orderByDesc('id_peminjaman')
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjaman', 'search'));
    }

    public function create(): View
    {
        $anggota = Anggota::query()
            ->where('status', '!=', 'Non Aktif')
            ->orderBy('nama')
            ->get();
        $buku = Buku::query()->available()->orderBy('judul')->get();
        $tanggalPinjam = today()->toDateString();
        $tanggalKembali = today()->addDays((int) config('library.loan_duration_days'))->toDateString();

        return view('admin.peminjaman.create', compact(
            'anggota',
            'buku',
            'tanggalPinjam',
            'tanggalKembali',
        ));
    }

    public function store(StorePeminjamanRequest $request, PeminjamanService $peminjamanService): RedirectResponse
    {
        try {
            $peminjamanService->create(
                (int) $request->validated('anggota_id'),
                $request->validated('buku_dipinjam'),
            );
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            Log::error('Gagal membuat transaksi peminjaman.', ['exception' => $exception]);

            return back()->withInput()->withErrors([
                'error' => 'Transaksi belum dapat disimpan. Silakan coba lagi.',
            ]);
        }

        return to_route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['anggota', 'detailPeminjaman.buku']);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman): View|RedirectResponse
    {
        $peminjaman->load(['anggota', 'detailPeminjaman.buku']);

        if ($peminjaman->status === 'Dikembalikan') {
            return to_route('admin.peminjaman.show', $peminjaman)
                ->with('error', 'Semua buku pada transaksi ini sudah dikembalikan.');
        }

        $hariTerlambat = $peminjaman->is_terlambat
            ? (int) $peminjaman->tanggal_kembali->diffInDays(today())
            : 0;
        $totalDenda = $hariTerlambat * (int) config('library.late_fee_per_day');
        $bukuBelumKembali = $peminjaman->detailPeminjaman
            ->where('status_item', 'Dipinjam');

        return view('admin.peminjaman.edit', compact(
            'peminjaman',
            'hariTerlambat',
            'totalDenda',
            'bukuBelumKembali',
        ));
    }

    public function returnItems(
        ReturnPeminjamanRequest $request,
        Peminjaman $peminjaman,
        PeminjamanService $peminjamanService,
    ): RedirectResponse {
        try {
            $peminjamanService->returnItems(
                $peminjaman,
                $request->validated('details_kembali'),
            );
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            Log::error('Gagal memproses pengembalian.', [
                'peminjaman_id' => $peminjaman->getKey(),
                'exception' => $exception,
            ]);

            return back()->withErrors([
                'error' => 'Pengembalian belum dapat diproses. Silakan coba lagi.',
            ]);
        }

        return to_route('admin.peminjaman.show', $peminjaman)
            ->with('success', 'Buku terpilih berhasil dikembalikan.');
    }

    public function sendReminders(LoanReminderService $reminderService): RedirectResponse
    {
        try {
            $sent = $reminderService->sendUpcoming(2);
        } catch (\Throwable $exception) {
            Log::error('Gagal mengirim pengingat jatuh tempo.', ['exception' => $exception]);

            return back()->with('error', 'Pengingat belum dapat dikirim. Periksa konfigurasi email aplikasi.');
        }

        return back()->with('success', "{$sent} pengingat jatuh tempo berhasil dikirim.");
    }
}
