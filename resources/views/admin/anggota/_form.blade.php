@php
    $member = $anggota ?? null;
    $statuses = ['Mahasiswa', 'Dosen', 'Dosen Luar', 'Non Aktif'];
@endphp

@csrf
@if (isset($method) && $method !== 'POST')
    @method($method)
@endif

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
        <strong>Data belum dapat disimpan.</strong>
        <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-7">
        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <input id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $member?->nama) }}" maxlength="100" required autofocus>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-5">
        <label for="no_telp" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
        <input id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $member?->no_telp) }}" maxlength="20" required>
        @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="no_identitas" class="form-label">Nomor Identitas</label>
        <input id="no_identitas" name="no_identitas" class="form-control @error('no_identitas') is-invalid @enderror" value="{{ old('no_identitas', $member?->no_identitas) }}" maxlength="50" placeholder="NIM, NIP, atau KTP">
        @error('no_identitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status Anggota <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $member?->status ?? 'Mahasiswa') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label for="email" class="form-label">Email Pengingat</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $member?->email) }}" maxlength="255" placeholder="nama@contoh.ac.id">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" role="switch" id="reminder_opt_in" name="reminder_opt_in" value="1" @checked(old('reminder_opt_in', $member?->reminder_opt_in ?? true))>
            <label class="form-check-label" for="reminder_opt_in">Pengingat jatuh tempo</label>
        </div>
    </div>
    <div class="col-12">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4">{{ old('alamat', $member?->alamat) }}</textarea>
        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary">Batal</a>
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>{{ $submitLabel }}</button>
</div>
