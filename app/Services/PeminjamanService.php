<?php

namespace App\Services;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanService
{
    /**
     * @param  array<int, int|string>  $documentIds
     */
    public function create(int $anggotaId, array $documentIds): Peminjaman
    {
        return DB::transaction(function () use ($anggotaId, $documentIds): Peminjaman {
            $anggota = Anggota::query()->lockForUpdate()->findOrFail($anggotaId);

            if ($anggota->status === 'Non Aktif') {
                throw ValidationException::withMessages([
                    'anggota_id' => 'Anggota non aktif tidak dapat meminjam koleksi.',
                ]);
            }

            $quantities = array_count_values(array_map(static fn ($id): int => (int) $id, $documentIds));
            $books = Buku::query()
                ->whereIn('no_document', array_keys($quantities))
                ->lockForUpdate()
                ->get()
                ->keyBy('no_document');

            foreach ($quantities as $noDocument => $quantity) {
                $buku = $books->get($noDocument);

                if (! $buku || $buku->jumlah_tersedia < $quantity) {
                    throw ValidationException::withMessages([
                        'buku_dipinjam' => "Stok buku '{$buku?->judul}' tidak mencukupi.",
                    ]);
                }
            }

            $tanggalPinjam = today();
            $peminjaman = Peminjaman::create([
                'no_anggota' => $anggota->getKey(),
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali' => $tanggalPinjam->copy()->addDays((int) config('library.loan_duration_days')),
            ]);

            foreach ($quantities as $noDocument => $quantity) {
                $peminjaman->detailPeminjaman()->create([
                    'no_document' => $noDocument,
                    'jumlah_pinjam' => $quantity,
                    'status_item' => 'Dipinjam',
                ]);

                $books->get($noDocument)->decrement('jumlah_tersedia', $quantity);
            }

            return $peminjaman->load(['anggota', 'detailPeminjaman.buku']);
        }, attempts: 3);
    }

    /**
     * @param  array<int, int|string>  $documentIds
     */
    public function returnItems(Peminjaman $peminjaman, array $documentIds): void
    {
        DB::transaction(function () use ($peminjaman, $documentIds): void {
            $loan = Peminjaman::query()->lockForUpdate()->findOrFail($peminjaman->getKey());
            $documentIds = array_values(array_unique(array_map(static fn ($id): int => (int) $id, $documentIds)));

            $details = DetailPeminjaman::query()
                ->where('id_peminjaman', $loan->getKey())
                ->whereIn('no_document', $documentIds)
                ->where('status_item', 'Dipinjam')
                ->lockForUpdate()
                ->get();

            if ($details->count() !== count($documentIds)) {
                throw ValidationException::withMessages([
                    'details_kembali' => 'Satu atau lebih buku tidak valid atau sudah dikembalikan.',
                ]);
            }

            $books = Buku::query()
                ->whereIn('no_document', $details->pluck('no_document'))
                ->lockForUpdate()
                ->get()
                ->keyBy('no_document');

            foreach ($details as $detail) {
                $buku = $books->get($detail->no_document);

                if (! $buku) {
                    throw ValidationException::withMessages([
                        'details_kembali' => 'Salah satu buku pada transaksi ini tidak lagi tersedia.',
                    ]);
                }

                DetailPeminjaman::query()
                    ->where('id_peminjaman', $loan->getKey())
                    ->where('no_document', $detail->no_document)
                    ->where('status_item', 'Dipinjam')
                    ->update([
                        'status_item' => 'Dikembalikan',
                        'tanggal_dikembalikan' => today(),
                        'updated_at' => now(),
                    ]);

                $buku->increment('jumlah_tersedia', $detail->jumlah_pinjam);
            }
        }, attempts: 3);
    }
}
