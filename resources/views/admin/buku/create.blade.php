@extends('layouts.app')

@section('title', 'Tambah Koleksi')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Akuisisi Koleksi</span><p>Catat metadata, abstrak untuk klasifikasi otomatis, dan stok awal koleksi baru.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
    </div>

    <div class="card">
        <div class="card-header"><strong>Form Koleksi Baru</strong></div>
        <div class="card-body p-4">
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.buku._form', ['buku' => null, 'method' => 'POST', 'submitLabel' => 'Simpan Koleksi'])
            </form>
        </div>
    </div>
@endsection
