@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="admin-page-intro">
                <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Anggota Baru</span><p>Tambahkan identitas anggota yang dapat menggunakan layanan sirkulasi.</p></div>
                <div class="admin-page-actions"><a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
            </div>
            <div class="card">
                <div class="card-header"><strong>Informasi Anggota</strong></div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.anggota.store') }}" method="POST">
                        @include('admin.anggota._form', ['submitLabel' => 'Simpan Anggota'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
