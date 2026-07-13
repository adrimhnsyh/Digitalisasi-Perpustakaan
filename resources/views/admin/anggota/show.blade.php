@extends('layouts.app')

@section('title', 'Anggota #' . $anggota->no_anggota)

@section('content')
    @php
        $badgeClass = match ($anggota->status) {
            'Mahasiswa' => 'text-bg-primary',
            'Dosen' => 'text-bg-success',
            'Dosen Luar' => 'text-bg-warning text-dark',
            default => 'text-bg-secondary',
        };
    @endphp

    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Profil Anggota</span><p>Identitas, preferensi pengingat, dan riwayat peminjaman {{ $anggota->nama }}.</p></div>
        <div class="admin-page-actions">
            <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Edit</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $anggota->nama }}</strong>
                    <span class="badge {{ $badgeClass }}">{{ $anggota->status }}</span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted fw-medium">No. anggota</dt><dd class="col-sm-7">#{{ $anggota->no_anggota }}</dd>
                        <dt class="col-sm-5 text-muted fw-medium">Identitas</dt><dd class="col-sm-7">{{ $anggota->no_identitas ?: '-' }}</dd>
                        <dt class="col-sm-5 text-muted fw-medium">Telepon</dt><dd class="col-sm-7">{{ $anggota->no_telp }}</dd>
                        <dt class="col-sm-5 text-muted fw-medium">Email</dt><dd class="col-sm-7">{{ $anggota->email ?: '-' }}</dd>
                        <dt class="col-sm-5 text-muted fw-medium">Pengingat</dt><dd class="col-sm-7">{{ $anggota->reminder_opt_in ? 'Aktif' : 'Nonaktif' }}</dd>
                        <dt class="col-sm-5 text-muted fw-medium">Bergabung</dt><dd class="col-sm-7">{{ $anggota->created_at?->format('d/m/Y') ?? '-' }}</dd>
                    </dl>
                    <hr>
                    <div class="text-muted small text-uppercase fw-bold mb-1">Alamat</div>
                    <div>{{ $anggota->alamat ?: '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header"><strong>Riwayat Peminjaman</strong></div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th class="ps-4">Transaksi</th><th>Tanggal</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse ($anggota->peminjaman->sortByDesc('tanggal_pinjam')->take(8) as $loan)
                                <tr>
                                    <td class="ps-4"><a class="fw-semibold text-decoration-none" href="{{ route('admin.peminjaman.show', $loan) }}">#{{ $loan->id_peminjaman }}</a></td>
                                    <td>{{ $loan->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</td>
                                    <td><span class="badge {{ $loan->status === 'Dikembalikan' ? 'text-bg-success' : ($loan->is_terlambat ? 'text-bg-danger' : 'text-bg-warning text-dark') }}">{{ $loan->is_terlambat ? 'Terlambat' : $loan->status }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-5 text-center text-muted">Belum ada riwayat peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
