@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="admin-page-intro">
                <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Perbarui Anggota</span><p>Perbarui informasi untuk {{ $anggota->nama }}.</p></div>
                <div class="admin-page-actions"><a href="{{ route('admin.anggota.show', $anggota) }}" class="btn btn-outline-secondary">Lihat Detail</a></div>
            </div>
            <div class="card">
                <div class="card-header"><strong>Informasi Anggota</strong></div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.anggota.update', $anggota) }}" method="POST">
                        @include('admin.anggota._form', ['method' => 'PUT', 'submitLabel' => 'Simpan Perubahan'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
