@extends('layouts.app')

@section('title', 'Anggota')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Keanggotaan</span><p>Kelola data anggota yang dapat meminjam koleksi perpustakaan.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.anggota.create') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Tambah Anggota</a></div>
    </div>

    <div class="card admin-data-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Daftar Anggota</strong>
            <span class="text-muted small">{{ $anggota->total() }} anggota</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr><th class="ps-4">No.</th><th>Nama</th><th>Kontak</th><th>Status</th><th class="text-end pe-4">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($anggota as $item)
                        @php
                            $badgeClass = match ($item->status) {
                                'Mahasiswa' => 'text-bg-primary',
                                'Dosen' => 'text-bg-success',
                                'Dosen Luar' => 'text-bg-warning text-dark',
                                default => 'text-bg-secondary',
                            };
                        @endphp
                        <tr>
                            <td class="ps-4">#{{ $item->no_anggota }}</td>
                            <td><a href="{{ route('admin.anggota.show', $item) }}" class="fw-semibold text-decoration-none">{{ $item->nama }}</a></td>
                            <td><div>{{ $item->no_telp }}</div><small class="text-muted">{{ $item->email ?: 'Email belum diisi' }}</small></td>
                            <td><span class="badge {{ $badgeClass }}">{{ $item->status }}</span></td>
                            <td class="pe-4 text-end text-nowrap">
                                <a href="{{ route('admin.anggota.show', $item) }}" class="btn btn-sm btn-outline-primary" aria-label="Lihat {{ $item->nama }}"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.anggota.edit', $item) }}" class="btn btn-sm btn-outline-secondary ms-1" aria-label="Edit {{ $item->nama }}"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.anggota.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus anggota ini? Riwayat peminjaman akan membuat penghapusan ditolak.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger ms-1" type="submit" aria-label="Hapus {{ $item->nama }}"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-5 text-center text-muted">Belum ada data anggota.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($anggota->hasPages())
            <div class="card-body border-top">{{ $anggota->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
