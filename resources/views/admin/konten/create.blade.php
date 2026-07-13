@extends('layouts.app')

@section('title', 'Tambah Konten Publik')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Publikasi Baru</span><p>Buat berita, agenda, FAQ, panduan, profil, karya mahasiswa, atau tantangan untuk website depan.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.konten.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
    </div>
    <form action="{{ route('admin.konten.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.konten._form', ['konten' => null, 'method' => 'POST', 'submitLabel' => 'Simpan'])
    </form>
@endsection
