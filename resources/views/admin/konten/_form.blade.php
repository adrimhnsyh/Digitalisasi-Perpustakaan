@php($content = $konten ?? null)

@csrf
@if (($method ?? 'POST') !== 'POST')
    @method($method)
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Konten belum dapat disimpan.</strong>
        <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><strong>Isi Konten</strong></div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="type" class="form-label">Jenis Konten <span class="text-danger">*</span></label>
                        <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                            @foreach (\App\Models\KontenPublik::TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('type', $content?->type ?? request('type', 'berita')) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $content?->title) }}" maxlength="255" required>
                    </div>
                    <div class="col-12">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea id="excerpt" name="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Ringkasan singkat untuk kartu di halaman publik">{{ old('excerpt', $content?->excerpt) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label for="body" class="form-label">Isi Lengkap</label>
                        <textarea id="body" name="body" rows="12" class="form-control @error('body') is-invalid @enderror">{{ old('body', $content?->body) }}</textarea>
                        <div class="form-text">Teks akan ditampilkan dengan pemisah baris yang aman pada halaman publik.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="event_at" class="form-label">Mulai / Tanggal Agenda</label>
                        <input id="event_at" name="event_at" type="datetime-local" class="form-control @error('event_at') is-invalid @enderror" value="{{ old('event_at', $content?->event_at?->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="event_end_at" class="form-label">Selesai</label>
                        <input id="event_end_at" name="event_end_at" type="datetime-local" class="form-control @error('event_end_at') is-invalid @enderror" value="{{ old('event_end_at', $content?->event_end_at?->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="col-12">
                        <label for="external_url" class="form-label">Tautan Eksternal / Internal</label>
                        <input id="external_url" name="external_url" class="form-control @error('external_url') is-invalid @enderror" value="{{ old('external_url', $content?->external_url) }}" placeholder="https://... atau /layanan">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><strong>Publikasi</strong></div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Urutan</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="9999" class="form-control" value="{{ old('sort_order', $content?->sort_order ?? 0) }}" required>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $content?->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Terbitkan ke website</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $content?->is_featured))>
                    <label class="form-check-label" for="is_featured">Jadikan unggulan</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><strong>Media</strong></div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="form-control @error('image') is-invalid @enderror">
                    @if ($content?->image_url)
                        <img src="{{ $content->image_url }}" class="img-fluid mt-3 border" alt="Pratinjau gambar">
                        <div class="form-check mt-2"><input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1"><label class="form-check-label small" for="remove_image">Hapus gambar</label></div>
                    @endif
                </div>
                <div>
                    <label for="attachment" class="form-label">Lampiran</label>
                    <input id="attachment" name="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror">
                    @if ($content?->attachment_path)
                        <div class="form-check mt-2"><input class="form-check-input" type="checkbox" id="remove_attachment" name="remove_attachment" value="1"><label class="form-check-label small" for="remove_attachment">Hapus lampiran</label></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('admin.konten.index') }}" class="btn btn-outline-secondary flex-fill">Batal</a>
            <button class="btn btn-primary flex-fill" type="submit"><i class="fa-solid fa-floppy-disk me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</div>
