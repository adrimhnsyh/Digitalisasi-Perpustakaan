@extends('layouts.app')

@section('title', 'Permintaan #' . $permintaan->id)

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Tindak Lanjut Layanan</span><p>{{ $permintaan->type_label }} dari {{ $permintaan->name }} yang dikirim melalui website depan.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.permintaan.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between"><strong>{{ $permintaan->subject }}</strong><span class="badge text-bg-light border">{{ $permintaan->type_label }}</span></div>
                <div class="card-body p-4">
                    <p style="white-space:pre-line">{{ $permintaan->message }}</p>
                    <hr>
                    <dl class="row mb-0 small">
                        <dt class="col-sm-3 text-muted">Nama</dt><dd class="col-sm-9">{{ $permintaan->name }}</dd>
                        <dt class="col-sm-3 text-muted">Email</dt><dd class="col-sm-9">{{ $permintaan->email ?: '-' }}</dd>
                        <dt class="col-sm-3 text-muted">Telepon</dt><dd class="col-sm-9">{{ $permintaan->phone ?: '-' }}</dd>
                        <dt class="col-sm-3 text-muted">Nomor anggota</dt><dd class="col-sm-9">{{ $permintaan->member_number ?: '-' }}</dd>
                        <dt class="col-sm-3 text-muted">Dikirim</dt><dd class="col-sm-9">{{ $permintaan->created_at?->translatedFormat('d F Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('admin.permintaan.update', $permintaan) }}" method="POST" class="card">
                @csrf
                @method('PUT')
                <div class="card-header"><strong>Tindak Lanjut</strong></div>
                <div class="card-body p-4">
                    <div class="mb-3"><label for="status" class="form-label">Status</label><select id="status" name="status" class="form-select">@foreach(\App\Models\PermintaanPublik::STATUSES as $value => $label)<option value="{{ $value }}" @selected(old('status', $permintaan->status) === $value)>{{ $label }}</option>@endforeach</select></div>
                    <div class="mb-3"><label for="admin_notes" class="form-label">Catatan Admin</label><textarea id="admin_notes" name="admin_notes" rows="7" class="form-control">{{ old('admin_notes', $permintaan->admin_notes) }}</textarea></div>
                    <button class="btn btn-primary w-100">Simpan Tindak Lanjut</button>
                </div>
            </form>
            <form action="{{ route('admin.permintaan.destroy', $permintaan) }}" method="POST" class="mt-3" onsubmit="return confirm('Hapus permintaan ini secara permanen?')">@csrf @method('DELETE')<button class="btn btn-outline-danger w-100">Hapus Permintaan</button></form>
        </div>
    </div>
@endsection
