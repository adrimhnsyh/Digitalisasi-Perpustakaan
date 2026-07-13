@extends('layouts.app')

@section('title', 'Transaksi #' . $peminjaman->id_peminjaman)

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Detail Sirkulasi</span><p>Periksa peminjam, tenggat, serta status setiap koleksi pada transaksi ini.</p></div>
        <div class="admin-page-actions">
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
            @if ($peminjaman->status === 'Dipinjam')
                <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}" class="btn btn-primary"><i class="fa-solid fa-rotate-left me-2"></i>Pengembalian</a>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <div class="text-muted small text-uppercase fw-bold mb-1">Peminjam</div>
                    <div class="fs-5 fw-bold">{{ $peminjaman->anggota?->nama ?? 'Anggota tidak tersedia' }}</div>
                    <div class="text-muted">No. anggota {{ $peminjaman->no_anggota }}</div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="text-muted small text-uppercase fw-bold mb-1">Tanggal Pinjam</div>
                    <div class="fw-semibold">{{ $peminjaman->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="text-muted small text-uppercase fw-bold mb-1">Batas Kembali</div>
                    <div class="fw-semibold">{{ $peminjaman->tanggal_kembali?->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="col-md-2 text-md-end">
                    @if ($peminjaman->status === 'Dikembalikan')
                        <span class="badge text-bg-success">Dikembalikan</span>
                    @elseif ($peminjaman->is_terlambat)
                        <span class="badge text-bg-danger">Terlambat</span>
                    @else
                        <span class="badge text-bg-warning text-dark">Dipinjam</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><strong>Item Peminjaman</strong></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr><th class="ps-4">Dokumen</th><th>Judul</th><th>Penulis</th><th>Jumlah</th><th>Status</th><th class="pe-4">Dikembalikan Pada</th></tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman->detailPeminjaman as $detail)
                        <tr>
                            <td class="ps-4">#{{ $detail->no_document }}</td>
                            <td class="fw-semibold">{{ $detail->buku?->judul ?? 'Koleksi tidak tersedia' }}</td>
                            <td>{{ $detail->buku?->penulis ?? '-' }}</td>
                            <td>{{ $detail->jumlah_pinjam }}</td>
                            <td><span class="badge {{ $detail->status_item === 'Dikembalikan' ? 'text-bg-success' : 'text-bg-warning text-dark' }}">{{ $detail->status_item }}</span></td>
                            <td class="pe-4">{{ $detail->tanggal_dikembalikan?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-5 text-center text-muted">Belum ada detail koleksi untuk transaksi ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
