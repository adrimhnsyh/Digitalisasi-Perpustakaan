@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Sirkulasi</span><p>Pantau transaksi aktif, keterlambatan, riwayat pengembalian, dan pengingat anggota.</p></div>
        <div class="admin-page-actions">
            <form action="{{ route('admin.peminjaman.send-reminders') }}" method="POST" onsubmit="return confirm('Kirim pengingat email untuk peminjaman yang jatuh tempo dalam dua hari?')">
                @csrf
                <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-paper-plane me-2"></i>Kirim Pengingat</button>
            </form>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Buat Peminjaman
            </a>
        </div>
    </div>

    <div class="card admin-filter-card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="row g-2">
                <div class="col-md">
                    <label class="visually-hidden" for="search">Cari transaksi</label>
                    <input id="search" name="search" class="form-control" value="{{ $search }}" placeholder="Cari ID transaksi, nama, atau nomor anggota">
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari</button>
                    @if ($search !== '')
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card admin-data-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <strong>Riwayat Transaksi</strong>
            <span class="text-muted small">{{ $peminjaman->total() }} transaksi</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Transaksi</th>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                        @php
                            $isLate = $item->is_terlambat;
                            $displayStatus = $isLate ? 'Terlambat' : $item->status;
                        @endphp
                        <tr class="{{ $isLate ? 'table-danger' : '' }}">
                            <td class="ps-4"><a class="fw-bold text-decoration-none" href="{{ route('admin.peminjaman.show', $item) }}">#{{ $item->id_peminjaman }}</a></td>
                            <td>
                                <div class="fw-semibold">{{ $item->anggota?->nama ?? 'Anggota tidak tersedia' }}</div>
                                <small class="text-muted">No. {{ $item->no_anggota }}</small>
                            </td>
                            <td>{{ $item->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</td>
                            <td class="{{ $isLate ? 'fw-bold text-danger' : '' }}">{{ $item->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $item->status === 'Dikembalikan' ? 'text-bg-success' : ($isLate ? 'text-bg-danger' : 'text-bg-warning') }} {{ $item->status !== 'Dikembalikan' && ! $isLate ? 'text-dark' : '' }}">
                                    {{ $displayStatus }}
                                </span>
                            </td>
                            <td class="pe-4 text-end text-nowrap">
                                <a href="{{ route('admin.peminjaman.show', $item) }}" class="btn btn-sm btn-outline-primary" aria-label="Lihat transaksi {{ $item->id_peminjaman }}"><i class="fa-solid fa-eye"></i></a>
                                @if ($item->status === 'Dipinjam')
                                    <a href="{{ route('admin.peminjaman.edit', $item) }}" class="btn btn-sm btn-primary ms-1">Kembalikan</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-5 text-center text-muted">Belum ada transaksi yang sesuai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($peminjaman->hasPages())
            <div class="card-body border-top">{{ $peminjaman->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
