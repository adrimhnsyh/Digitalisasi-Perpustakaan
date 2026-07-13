@extends('layouts.app')

@section('title', 'Atur ' . $klasifikasi->kode)

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Kamus {{ $klasifikasi->kode }}</span><p>Perbarui identitas dan kata kunci yang dipakai mesin klasifikasi abstrak.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.klasifikasi.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
    </div>

    <form action="{{ route('admin.klasifikasi.update', $klasifikasi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-header"><strong>Kamus Analisis</strong></div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <label for="keywords_text" class="form-label">Kata Kunci <span class="text-danger">*</span></label>
                        <textarea id="keywords_text" name="keywords_text" rows="16" class="form-control @error('keywords_text') is-invalid @enderror" required>{{ old('keywords_text', implode("\n", $klasifikasi->keywords ?? [])) }}</textarea>
                        @error('keywords_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Pisahkan dengan baris baru atau koma. Gunakan frasa spesifik seperti "lean manufacturing" agar hasil lebih akurat.</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header"><strong>Informasi Kelompok</strong></div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input id="nama" name="nama" class="form-control" value="{{ old('nama', $klasifikasi->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="program_studi" class="form-label">Program Studi</label>
                            <input id="program_studi" name="program_studi" class="form-control" value="{{ old('program_studi', $klasifikasi->program_studi) }}">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $klasifikasi->deskripsi) }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="warna" class="form-label">Warna</label>
                                <input id="warna" name="warna" type="color" class="form-control form-control-color w-100" value="{{ old('warna', $klasifikasi->warna) }}">
                            </div>
                            <div class="col-6">
                                <label for="sort_order" class="form-label">Urutan</label>
                                <input id="sort_order" name="sort_order" type="number" min="0" class="form-control" value="{{ old('sort_order', $klasifikasi->sort_order) }}" required>
                            </div>
                            <div class="col-12">
                                <label for="ikon" class="form-label">Ikon Bootstrap</label>
                                <input id="ikon" name="ikon" class="form-control" value="{{ old('ikon', $klasifikasi->ikon) }}" required>
                            </div>
                        </div>
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $klasifikasi->is_active))>
                            <label class="form-check-label" for="is_active">Aktif untuk klasifikasi otomatis</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100 mt-3" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Kamus</button>
            </div>
        </div>
    </form>
@endsection
