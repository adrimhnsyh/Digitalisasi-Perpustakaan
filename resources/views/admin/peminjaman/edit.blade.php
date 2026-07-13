@extends('layouts.app')

@section('title', 'Pengembalian #' . $peminjaman->id_peminjaman)

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Pengembalian Koleksi</span><p>Pilih item yang diterima kembali dan periksa keterlambatan transaksi.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.peminjaman.show', $peminjaman) }}" class="btn btn-outline-secondary">Kembali ke Detail</a></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><strong>Ringkasan Peminjaman</strong></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fw-medium">Anggota</dt><dd class="col-7">{{ $peminjaman->anggota?->nama }}</dd>
                        <dt class="col-5 text-muted fw-medium">Dipinjam</dt><dd class="col-7">{{ $peminjaman->tanggal_pinjam?->format('d/m/Y') }}</dd>
                        <dt class="col-5 text-muted fw-medium">Batas</dt><dd class="col-7">{{ $peminjaman->tanggal_kembali?->format('d/m/Y') }}</dd>
                    </dl>
                    <hr>
                    @if ($hariTerlambat > 0)
                        <div class="alert alert-danger mb-0"><strong>{{ $hariTerlambat }} hari terlambat</strong><br>Denda berjalan: Rp{{ number_format($totalDenda, 0, ',', '.') }}</div>
                    @else
                        <div class="alert alert-success mb-0">Transaksi masih dalam batas waktu pengembalian.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <form action="{{ route('admin.peminjaman.return-items', $peminjaman) }}" method="POST" class="card">
                @csrf
                <div class="card-header d-flex align-items-center justify-content-between">
                    <strong>Pilih Koleksi yang Dikembalikan</strong>
                    <span class="text-muted small">Pilih satu atau lebih item</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr><th class="ps-4"><input class="form-check-input" type="checkbox" id="check-all" aria-label="Pilih semua"></th><th>Dokumen</th><th>Judul</th><th>Jumlah</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($bukuBelumKembali as $detail)
                                <tr>
                                    <td class="ps-4"><input class="form-check-input return-item" type="checkbox" name="details_kembali[]" value="{{ $detail->no_document }}"></td>
                                    <td>#{{ $detail->no_document }}</td>
                                    <td class="fw-semibold">{{ $detail->buku?->judul ?? 'Koleksi tidak tersedia' }}</td>
                                    <td>{{ $detail->jumlah_pinjam }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-5 text-center text-muted">Tidak ada koleksi yang perlu dikembalikan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @error('details_kembali')<div class="alert alert-danger mx-3 mt-3 mb-0">{{ $message }}</div>@enderror
                <div class="card-footer bg-white d-flex justify-content-between py-3">
                    <a href="{{ route('admin.peminjaman.show', $peminjaman) }}" class="btn btn-outline-secondary">Kembali ke Detail</a>
                    <button id="return-submit" type="submit" class="btn btn-primary" @disabled($bukuBelumKembali->isEmpty())><i class="fa-solid fa-rotate-left me-2"></i>Proses Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const checkAll = document.getElementById('check-all');
            const items = [...document.querySelectorAll('.return-item')];
            const submit = document.getElementById('return-submit');
            const sync = () => { if (submit) submit.disabled = !items.some((item) => item.checked); };

            if (checkAll) checkAll.addEventListener('change', () => { items.forEach((item) => item.checked = checkAll.checked); sync(); });
            items.forEach((item) => item.addEventListener('change', () => { if (checkAll) checkAll.checked = items.length > 0 && items.every((entry) => entry.checked); sync(); }));
            sync();
        })();
    </script>
@endpush
