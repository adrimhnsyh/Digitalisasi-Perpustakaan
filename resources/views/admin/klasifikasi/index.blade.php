@extends('layouts.app')

@section('title', 'Kamus Klasifikasi')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy">
            <span class="admin-page-intro__eyebrow">Mesin Klasifikasi</span>
            <p>Atur kata kunci yang dipakai untuk membaca abstrak dan mengelompokkan koleksi.</p>
            <small>Perubahan kamus berlaku pada analisis berikutnya. Gunakan analisis ulang untuk memperbarui koleksi lama.</small>
        </div>
        <div class="admin-page-actions"><form action="{{ route('admin.buku.reclassify') }}" method="POST" onsubmit="return confirm('Analisis ulang seluruh koleksi yang sudah memiliki abstrak?')">
                @csrf
                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-arrows-rotate me-2"></i>Analisis Ulang Koleksi</button>
            </form></div>
    </div>

    <div class="row g-4">
        @foreach ($classifications as $classification)
            <div class="col-md-6 col-xl-4">
                <article class="card classification-admin-card h-100" style="border-top:4px solid {{ $classification->warna }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <span class="d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;background:{{ $classification->warna }}1f;color:{{ $classification->warna }}">
                                <i class="bi {{ $classification->ikon }} fs-5"></i>
                            </span>
                            <span class="badge {{ $classification->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $classification->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                        <div class="text-muted small fw-bold mb-1">{{ $classification->kode }}</div>
                        <h2 class="h5">{{ $classification->nama }}</h2>
                        <p class="text-muted small">{{ $classification->deskripsi }}</p>
                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4">
                            <span class="small text-muted"><strong>{{ $classification->buku_count }}</strong> koleksi / {{ count($classification->keywords ?? []) }} kata kunci</span>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.klasifikasi.edit', $classification) }}">Atur</a>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
@endsection
