@extends('layouts.app')

@section('title', 'Edit Koleksi')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Perbarui Koleksi</span><p>Perbarui metadata, abstrak, klasifikasi, dan stok untuk {{ $buku->judul }}.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.buku.show', $buku) }}" class="btn btn-outline-secondary">Lihat Detail</a></div>
    </div>

    <div class="card">
        <div class="card-header"><strong>Form Koleksi #{{ $buku->no_document }}</strong></div>
        <div class="card-body p-4">
            <form action="{{ route('admin.buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
                @include('admin.buku._form', ['method' => 'PUT', 'submitLabel' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
@endsection
