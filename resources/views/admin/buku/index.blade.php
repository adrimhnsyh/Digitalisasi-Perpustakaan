@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Katalog Internal</span><p>Kelola metadata, klasifikasi abstrak, dan ketersediaan seluruh eksemplar.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.buku.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tambah Koleksi</a></div>
    </div>

    <div class="card admin-filter-card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.buku.index') }}" method="GET" class="row g-2">
                <div class="col-lg">
                    <label class="visually-hidden" for="search">Cari koleksi</label>
                    <input id="search" name="search" class="form-control" value="{{ $search }}" placeholder="Cari judul, penulis, kode panggil, atau nomor dokumen">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <label class="visually-hidden" for="classification">Kelompok subjek</label>
                    <select id="classification" name="classification" class="form-select">
                        <option value="">Semua kelompok</option>
                        @foreach ($classifications as $item)
                            <option value="{{ $item->id }}" @selected($classification === $item->id)>{{ $item->kode }} - {{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <label class="visually-hidden" for="type">Jenis koleksi</label>
                    <select id="type" name="type" class="form-select">
                        <option value="">Semua jenis</option>
                        @foreach (['Buku', 'Jurnal', 'Tugas Akhir'] as $itemType)
                            <option value="{{ $itemType }}" @selected($documentType === $itemType)>{{ $itemType }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Cari</button>
                    @if ($search !== '' || $classification || $documentType !== '')
                        <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card admin-data-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <strong>Daftar Koleksi</strong>
            <span class="text-muted small">{{ $buku->total() }} koleksi</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr><th class="ps-4">Dokumen</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Stok Tersedia</th><th class="text-end pe-4">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($buku as $item)
                        <tr>
                            <td class="ps-4">#{{ $item->no_document }}</td>
                            <td>
                                <a href="{{ route('admin.buku.show', $item) }}" class="fw-semibold text-decoration-none">{{ $item->judul }}</a>
                                @if ($item->kode_panggil)<div class="text-muted small">{{ $item->kode_panggil }}</div>@endif
                            </td>
                            <td>{{ $item->penulis ?: '-' }}</td>
                            <td>
                                <div>{{ $item->kategori ?: '-' }}</div>
                                @if ($item->klasifikasi)
                                    <span class="badge text-bg-light border mt-1" style="border-left:3px solid {{ $item->klasifikasi->warna }} !important">{{ $item->klasifikasi->kode }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $item->jumlah_tersedia > 0 ? 'text-bg-success' : 'text-bg-danger' }}">{{ $item->jumlah_tersedia }} / {{ $item->jumlah_dokumen }}</span>
                            </td>
                            <td class="pe-4 text-end text-nowrap">
                                <a href="{{ route('admin.buku.show', $item) }}" class="btn btn-sm btn-outline-primary" aria-label="Lihat {{ $item->judul }}"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.buku.edit', $item) }}" class="btn btn-sm btn-outline-secondary ms-1" aria-label="Edit {{ $item->judul }}"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.buku.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus koleksi ini? Koleksi dengan riwayat peminjaman tidak dapat dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger ms-1" type="submit" aria-label="Hapus {{ $item->judul }}"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-5 text-center text-muted">Belum ada koleksi yang sesuai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($buku->hasPages())
            <div class="card-body border-top">{{ $buku->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
