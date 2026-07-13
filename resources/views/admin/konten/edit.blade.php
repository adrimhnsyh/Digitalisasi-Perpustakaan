@extends('layouts.app')

@section('title', 'Edit Konten Publik')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Perbarui Publikasi</span><p>Perbarui konten “{{ $konten->title }}” yang tampil di website depan.</p></div>
        <div class="admin-page-actions">
            @if($konten->is_published)<a href="{{ route('public-content.show', $konten) }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Pratinjau</a>@endif
            <a href="{{ route('admin.konten.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
    <form action="{{ route('admin.konten.update', $konten) }}" method="POST" enctype="multipart/form-data">
        @include('admin.konten._form', ['method' => 'PUT', 'submitLabel' => 'Perbarui'])
    </form>
@endsection
