@extends('layouts.app')

@section('title', 'Detail Koleksi')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy">
            <span class="admin-page-intro__eyebrow">Detail Bibliografi</span>
            <h2 class="h3 mb-1">{{ $buku->judul }}</h2>
            <p class="text-muted mb-0">Dokumen #{{ $buku->no_document }}{{ $buku->kode_panggil ? ' · ' . $buku->kode_panggil : '' }}</p>
        </div>
        <div class="admin-page-actions">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('admin.buku.edit', $buku) }}" class="btn btn-primary"><i class="fa-solid fa-pen me-2"></i>Edit</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold mb-2">Stok Tersedia</div>
                    <div class="display-6 fw-bold {{ $buku->jumlah_tersedia > 0 ? 'text-success' : 'text-danger' }}">{{ $buku->jumlah_tersedia }}</div>
                    <div class="text-muted">dari {{ $buku->jumlah_dokumen }} eksemplar</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold mb-2">Klasifikasi</div>
                    <div class="fw-bold">{{ $buku->klasifikasi?->nama ?? 'Belum terklasifikasi' }}</div>
                    <div class="text-muted">{{ $buku->kategori ?: '-' }}{{ $buku->classification_score !== null ? ' / keyakinan '.number_format($buku->classification_score, 1).'%' : '' }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold mb-2">Lokasi</div>
                    <div class="fw-bold">{{ $buku->lokasi_dokumen ?: '-' }}</div>
                    <div class="text-muted">{{ $buku->media_dokumen ?: 'Media belum dicatat' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><strong>Metadata Bibliografi</strong></div>
        <div class="table-responsive">
            <table class="table mb-0">
                <tbody>
                    <tr><th class="ps-4 text-muted fw-medium" style="width: 30%">Judul pararel</th><td>{{ $buku->judul_pararel ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Judul lain</th><td>{{ $buku->judul_lain ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Penulis</th><td>{{ $buku->penulis ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Penulis badan</th><td>{{ $buku->penulis_badan ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Tanggung jawab</th><td>{{ $buku->pertanggungjawaban ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Tanggung jawab pararel</th><td>{{ $buku->pertanggungjawaban_pararel ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Badan lain / konferensi</th><td>{{ $buku->badan_lain ?: '-' }}{{ $buku->konferensi ? ' / ' . $buku->konferensi : '' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Penerbit</th><td>{{ $buku->nama_penerbit ?: '-' }}{{ $buku->lokasi_penerbit ? ' · ' . $buku->lokasi_penerbit : '' }}{{ $buku->tahun_terbit ? ' · ' . $buku->tahun_terbit : '' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Edisi / seri</th><td>{{ $buku->edisi ?: '-' }} / {{ $buku->seri ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Bahasa / jenis</th><td>{{ $buku->bahasa_teks ?: '-' }} / {{ $buku->jenis_dokumen ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Deskripsi fisik</th><td>{{ $buku->deskripsi_fisik ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Resensi</th><td>{{ $buku->resensi ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Kelompok subjek</th><td>{{ $buku->klasifikasi?->kode ?? '-' }} - {{ $buku->klasifikasi?->nama ?? 'Belum terklasifikasi' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Kata kunci klasifikasi</th><td>{{ implode(', ', $buku->classification_keywords ?? []) ?: '-' }}</td></tr>
                    <tr><th class="ps-4 text-muted fw-medium">Tautan digital</th><td>@if($buku->external_url)<a href="{{ $buku->external_url }}" target="_blank" rel="noopener noreferrer">Buka sumber <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i></a>@else - @endif</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header"><strong>Catatan</strong></div>
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold mb-1">Catatan Umum</div>
                    <p class="mb-4">{{ $buku->catatan_umum ?: '-' }}</p>
                    <div class="text-muted small text-uppercase fw-bold mb-1">Catatan Isi</div>
                    <p class="mb-0">{{ $buku->catatan_isi ?: '-' }}</p>
                    <hr>
                    <div class="text-muted small text-uppercase fw-bold mb-1">Abstrak</div>
                    <p class="mb-0" style="white-space:pre-line">{{ $buku->abstrak ?: 'Abstrak belum tersedia.' }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><strong>Administrasi</strong></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted fw-medium">Sumbangan</dt><dd class="col-7">{{ $buku->buku_sumbangan }}</dd>
                        <dt class="col-5 text-muted fw-medium">Dokumentalis</dt><dd class="col-7">{{ $buku->dokumentalis ?: '-' }}</dd>
                        <dt class="col-5 text-muted fw-medium">Tanggal katalog</dt><dd class="col-7">{{ $buku->tanggal_ketik?->format('d/m/Y') ?? '-' }}</dd>
                        <dt class="col-5 text-muted fw-medium">Dibuat</dt><dd class="col-7">{{ $buku->created_at?->format('d/m/Y H:i') ?? '-' }}</dd>
                        <dt class="col-5 text-muted fw-medium">Diperbarui</dt><dd class="col-7">{{ $buku->updated_at?->format('d/m/Y H:i') ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
