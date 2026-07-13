@php($book = $buku ?? null)

@csrf
@if ($method !== 'POST')
    @method($method)
@endif

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
        <strong>Data koleksi belum dapat disimpan.</strong>
        <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h2 class="h5 mb-1">Identitas Koleksi</h2>
        <p class="text-muted small mb-0">Data utama dan jumlah eksemplar fisik.</p>
    </div>
    @if ($book)
        <span class="badge text-bg-light border">No. dokumen #{{ $book->no_document }}</span>
    @endif
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <label for="judul" class="form-label">Judul Utama <span class="text-danger">*</span></label>
        <input id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $book?->judul) }}" maxlength="255" required autofocus>
        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-sm-6 col-lg-3">
        <label for="kode_panggil" class="form-label">Kode Panggil</label>
        <input id="kode_panggil" name="kode_panggil" class="form-control @error('kode_panggil') is-invalid @enderror" value="{{ old('kode_panggil', $book?->kode_panggil) }}" maxlength="100">
        @error('kode_panggil')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-sm-6 col-lg-3">
        <label for="jumlah_dokumen" class="form-label">Total Eksemplar <span class="text-danger">*</span></label>
        <input id="jumlah_dokumen" name="jumlah_dokumen" type="number" min="0" class="form-control @error('jumlah_dokumen') is-invalid @enderror" value="{{ old('jumlah_dokumen', $book?->jumlah_dokumen ?? 1) }}" required>
        @error('jumlah_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if ($book)<div class="form-text">Tersedia saat ini: {{ $book->jumlah_tersedia }} eksemplar.</div>@endif
    </div>
</div>

<hr class="my-4">
<h2 class="h5 mb-3">Bibliografi</h2>
<div class="row g-3">
    <div class="col-md-6">
        <label for="judul_pararel" class="form-label">Judul Pararel</label>
        <input id="judul_pararel" name="judul_pararel" class="form-control @error('judul_pararel') is-invalid @enderror" value="{{ old('judul_pararel', $book?->judul_pararel) }}" maxlength="255">
        @error('judul_pararel')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="judul_lain" class="form-label">Judul Lain</label>
        <input id="judul_lain" name="judul_lain" class="form-control @error('judul_lain') is-invalid @enderror" value="{{ old('judul_lain', $book?->judul_lain) }}" maxlength="255">
        @error('judul_lain')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="penulis" class="form-label">Penulis</label>
        <input id="penulis" name="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $book?->penulis) }}" maxlength="255">
        @error('penulis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="penulis_badan" class="form-label">Penulis Badan</label>
        <input id="penulis_badan" name="penulis_badan" class="form-control @error('penulis_badan') is-invalid @enderror" value="{{ old('penulis_badan', $book?->penulis_badan) }}" maxlength="255">
        @error('penulis_badan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="pertanggungjawaban" class="form-label">Pernyataan Tanggung Jawab</label>
        <input id="pertanggungjawaban" name="pertanggungjawaban" class="form-control @error('pertanggungjawaban') is-invalid @enderror" value="{{ old('pertanggungjawaban', $book?->pertanggungjawaban) }}" maxlength="255">
        @error('pertanggungjawaban')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="pertanggungjawaban_pararel" class="form-label">Tanggung Jawab Pararel</label>
        <input id="pertanggungjawaban_pararel" name="pertanggungjawaban_pararel" class="form-control @error('pertanggungjawaban_pararel') is-invalid @enderror" value="{{ old('pertanggungjawaban_pararel', $book?->pertanggungjawaban_pararel) }}" maxlength="255">
        @error('pertanggungjawaban_pararel')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="badan_lain" class="form-label">Badan Lain</label>
        <input id="badan_lain" name="badan_lain" class="form-control @error('badan_lain') is-invalid @enderror" value="{{ old('badan_lain', $book?->badan_lain) }}" maxlength="255">
        @error('badan_lain')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="konferensi" class="form-label">Konferensi</label>
        <input id="konferensi" name="konferensi" class="form-control @error('konferensi') is-invalid @enderror" value="{{ old('konferensi', $book?->konferensi) }}" maxlength="255">
        @error('konferensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-5">
        <label for="nama_penerbit" class="form-label">Penerbit</label>
        <input id="nama_penerbit" name="nama_penerbit" class="form-control @error('nama_penerbit') is-invalid @enderror" value="{{ old('nama_penerbit', $book?->nama_penerbit) }}" maxlength="255">
        @error('nama_penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="lokasi_penerbit" class="form-label">Lokasi Penerbitan</label>
        <input id="lokasi_penerbit" name="lokasi_penerbit" class="form-control @error('lokasi_penerbit') is-invalid @enderror" value="{{ old('lokasi_penerbit', $book?->lokasi_penerbit) }}" maxlength="255">
        @error('lokasi_penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
        <input id="tahun_terbit" name="tahun_terbit" type="number" min="1000" max="{{ now()->year }}" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $book?->tahun_terbit) }}">
        @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="edisi" class="form-label">Edisi</label>
        <input id="edisi" name="edisi" class="form-control @error('edisi') is-invalid @enderror" value="{{ old('edisi', $book?->edisi) }}" maxlength="100">
        @error('edisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="seri" class="form-label">Seri</label>
        <input id="seri" name="seri" class="form-control @error('seri') is-invalid @enderror" value="{{ old('seri', $book?->seri) }}" maxlength="100">
        @error('seri')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="bahasa_teks" class="form-label">Bahasa Teks</label>
        <input id="bahasa_teks" name="bahasa_teks" class="form-control @error('bahasa_teks') is-invalid @enderror" value="{{ old('bahasa_teks', $book?->bahasa_teks) }}" maxlength="255">
        @error('bahasa_teks')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<hr class="my-4">
<h2 class="h5 mb-3">Jenis, Klasifikasi, dan Deskripsi</h2>
<div class="row g-3">
    <div class="col-md-4">
        <label for="kategori" class="form-label">Jenis Koleksi <span class="text-danger">*</span></label>
        <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
            <option value="">Pilih kategori</option>
            @foreach (['Buku', 'Jurnal', 'Tugas Akhir'] as $category)
                <option value="{{ $category }}" @selected(old('kategori', $book?->kategori) === $category)>{{ $category }}</option>
            @endforeach
        </select>
        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="media_dokumen" class="form-label">Media Dokumen</label>
        <input id="media_dokumen" name="media_dokumen" class="form-control @error('media_dokumen') is-invalid @enderror" value="{{ old('media_dokumen', $book?->media_dokumen) }}" maxlength="100" placeholder="Contoh: Cetak">
        @error('media_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
        <input id="jenis_dokumen" name="jenis_dokumen" class="form-control @error('jenis_dokumen') is-invalid @enderror" value="{{ old('jenis_dokumen', $book?->jenis_dokumen) }}" maxlength="100">
        @error('jenis_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="subyek" class="form-label">Subyek</label>
        <input id="subyek" name="subyek" class="form-control @error('subyek') is-invalid @enderror" value="{{ old('subyek', $book?->subyek) }}" maxlength="255">
        @error('subyek')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        @php($classificationMode = old('classification_mode', $book?->classification_source === 'manual' ? 'manual' : 'auto'))
        <div class="classification-workbench p-3 p-lg-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="fa-solid fa-wand-magic-sparkles text-primary"></i>
                        <h3 class="h6 mb-0">Klasifikasi Berbasis Abstrak</h3>
                    </div>
                    <p class="text-muted small mb-0">Sistem membaca judul, subyek, dan abstrak dengan bobot berbeda untuk menemukan kelompok paling relevan.</p>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <div class="form-check">
                        <input class="form-check-input classification-mode" type="radio" name="classification_mode" id="classification_auto" value="auto" @checked($classificationMode === 'auto')>
                        <label class="form-check-label small fw-semibold" for="classification_auto">Otomatis</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input classification-mode" type="radio" name="classification_mode" id="classification_manual" value="manual" @checked($classificationMode === 'manual')>
                        <label class="form-check-label small fw-semibold" for="classification_manual">Pilih manual</label>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-8">
                    <label for="abstrak" class="form-label">Abstrak Buku @if (! $book)<span class="text-danger">*</span>@endif</label>
                    <textarea id="abstrak" name="abstrak" rows="7" class="form-control @error('abstrak') is-invalid @enderror" placeholder="Tuliskan ringkasan isi, tujuan, topik utama, metode, dan cakupan buku. Semakin lengkap abstraknya, semakin akurat hasil klasifikasi." @if (! $book) required @endif>{{ old('abstrak', $book?->abstrak) }}</textarea>
                    @error('abstrak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text"><span id="abstract-count">0</span> karakter. Minimal 80 karakter saat menambahkan koleksi.</div>
                </div>
                <div class="col-lg-4">
                    <label for="klasifikasi_id" class="form-label">Kelompok Subjek</label>
                    <select id="klasifikasi_id" name="klasifikasi_id" class="form-select @error('klasifikasi_id') is-invalid @enderror">
                        <option value="">Pilih kelompok</option>
                        @foreach ($classifications as $classification)
                            <option value="{{ $classification->id }}" @selected((int) old('klasifikasi_id', $book?->klasifikasi_id) === $classification->id)>{{ $classification->kode }} - {{ $classification->nama }}</option>
                        @endforeach
                    </select>
                    @error('klasifikasi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    <button id="classification-preview" class="btn btn-outline-primary w-100 mt-3" type="button">
                        <i class="fa-solid fa-magnifying-glass-chart me-2"></i>Analisis Sekarang
                    </button>

                    <div id="classification-result" class="mt-3 p-3 border bg-white" @if (! $book?->klasifikasi) hidden @endif>
                        <div class="text-muted text-uppercase small fw-bold mb-1">Hasil analisis</div>
                        <div id="classification-name" class="fw-bold">{{ $book?->klasifikasi?->nama }}</div>
                        <div id="classification-confidence" class="small text-muted">
                            @if ($book?->classification_score !== null)Keyakinan {{ number_format($book->classification_score, 1) }}%@endif
                        </div>
                        <div id="classification-keywords" class="small mt-2 text-muted">
                            {{ implode(', ', $book?->classification_keywords ?? []) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="lokasi_dokumen" class="form-label">Lokasi Dokumen</label>
        <input id="lokasi_dokumen" name="lokasi_dokumen" class="form-control @error('lokasi_dokumen') is-invalid @enderror" value="{{ old('lokasi_dokumen', $book?->lokasi_dokumen) }}" maxlength="255" placeholder="Rak atau ruang penyimpanan">
        @error('lokasi_dokumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="deskripsi_fisik" class="form-label">Deskripsi Fisik</label>
        <input id="deskripsi_fisik" name="deskripsi_fisik" class="form-control @error('deskripsi_fisik') is-invalid @enderror" value="{{ old('deskripsi_fisik', $book?->deskripsi_fisik) }}" maxlength="255" placeholder="Contoh: xii, 300 halaman; 21 cm">
        @error('deskripsi_fisik')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="resensi" class="form-label">Resensi Singkat</label>
        <input id="resensi" name="resensi" class="form-control @error('resensi') is-invalid @enderror" value="{{ old('resensi', $book?->resensi) }}" maxlength="255">
        @error('resensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="external_url" class="form-label">Tautan Digital</label>
        <input id="external_url" name="external_url" type="url" class="form-control @error('external_url') is-invalid @enderror" value="{{ old('external_url', $book?->external_url) }}" maxlength="255" placeholder="https://repository atau sumber e-book">
        @error('external_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="cover" class="form-label">Sampul Buku</label>
        <input id="cover" name="cover" type="file" accept="image/jpeg,image/png,image/webp" class="form-control @error('cover') is-invalid @enderror">
        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">JPG, PNG, atau WebP, maksimal 3 MB.</div>
        @if ($book?->cover_image)
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="remove_cover" value="1" id="remove_cover">
                <label class="form-check-label small" for="remove_cover">Hapus sampul saat ini</label>
            </div>
        @endif
    </div>
    <div class="col-12">
        <div class="d-flex flex-wrap gap-4 border p-3 bg-light">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_recommended" name="is_recommended" value="1" @checked(old('is_recommended', $book?->is_recommended))>
                <label class="form-check-label" for="is_recommended"><strong>Rekomendasi pustakawan</strong><br><small class="text-muted">Tampilkan pada pilihan kurasi.</small></label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $book?->is_featured))>
                <label class="form-check-label" for="is_featured"><strong>Buku minggu ini</strong><br><small class="text-muted">Hanya satu buku yang aktif.</small></label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="catatan_umum" class="form-label">Catatan Umum</label>
        <textarea id="catatan_umum" name="catatan_umum" rows="3" class="form-control @error('catatan_umum') is-invalid @enderror">{{ old('catatan_umum', $book?->catatan_umum) }}</textarea>
        @error('catatan_umum')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label for="catatan_isi" class="form-label">Catatan Isi</label>
        <textarea id="catatan_isi" name="catatan_isi" rows="3" class="form-control @error('catatan_isi') is-invalid @enderror">{{ old('catatan_isi', $book?->catatan_isi) }}</textarea>
        @error('catatan_isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

@push('scripts')
    <script>
        (() => {
            const title = document.getElementById('judul');
            const subject = document.getElementById('subyek');
            const abstract = document.getElementById('abstrak');
            const counter = document.getElementById('abstract-count');
            const select = document.getElementById('klasifikasi_id');
            const preview = document.getElementById('classification-preview');
            const result = document.getElementById('classification-result');
            const resultName = document.getElementById('classification-name');
            const resultConfidence = document.getElementById('classification-confidence');
            const resultKeywords = document.getElementById('classification-keywords');
            const modes = document.querySelectorAll('.classification-mode');

            const currentMode = () => document.querySelector('.classification-mode:checked')?.value ?? 'auto';
            const syncMode = () => {
                const automatic = currentMode() === 'auto';
                select.disabled = automatic;
                preview.disabled = !automatic;
            };
            const syncCount = () => counter.textContent = abstract.value.length.toLocaleString('id-ID');

            modes.forEach((mode) => mode.addEventListener('change', syncMode));
            abstract.addEventListener('input', syncCount);
            syncMode();
            syncCount();

            preview.addEventListener('click', async () => {
                if (!title.value.trim() || abstract.value.trim().length < 40) {
                    result.hidden = false;
                    resultName.textContent = 'Data belum cukup';
                    resultConfidence.textContent = 'Isi judul dan abstrak sedikitnya 40 karakter untuk melihat pratinjau.';
                    resultKeywords.textContent = '';
                    return;
                }

                preview.disabled = true;
                preview.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Menganalisis';

                try {
                    const response = await fetch('{{ route('admin.buku.classify') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ judul: title.value, subyek: subject.value, abstrak: abstract.value }),
                    });
                    const payload = await response.json();

                    if (!response.ok) {
                        throw new Error(payload.message ?? 'Analisis belum dapat dilakukan.');
                    }

                    const data = payload.data;
                    result.hidden = false;
                    resultName.textContent = `${data.code} - ${data.name}`;
                    resultConfidence.textContent = `Tingkat keyakinan ${Number(data.confidence).toLocaleString('id-ID')}%`;
                    resultKeywords.textContent = data.matched_keywords.length
                        ? `Kata kunci cocok: ${data.matched_keywords.join(', ')}`
                        : 'Belum ada kata kunci spesifik; koleksi ditempatkan pada kelompok umum.';
                    select.value = String(data.id ?? '');
                } catch (error) {
                    result.hidden = false;
                    resultName.textContent = 'Analisis gagal';
                    resultConfidence.textContent = error.message;
                    resultKeywords.textContent = '';
                } finally {
                    preview.disabled = currentMode() !== 'auto';
                    preview.innerHTML = '<i class="fa-solid fa-magnifying-glass-chart me-2"></i>Analisis Sekarang';
                }
            });
        })();
    </script>
@endpush

<hr class="my-4">
<h2 class="h5 mb-3">Administrasi</h2>
<div class="row g-3">
    <div class="col-md-4">
        <label for="tanggal_ketik" class="form-label">Tanggal Katalog</label>
        <input id="tanggal_ketik" name="tanggal_ketik" type="date" class="form-control @error('tanggal_ketik') is-invalid @enderror" value="{{ old('tanggal_ketik', $book?->tanggal_ketik?->format('Y-m-d')) }}">
        @error('tanggal_ketik')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="dokumentalis" class="form-label">Dokumentalis</label>
        <input id="dokumentalis" name="dokumentalis" class="form-control @error('dokumentalis') is-invalid @enderror" value="{{ old('dokumentalis', $book?->dokumentalis) }}" maxlength="255">
        @error('dokumentalis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label for="buku_sumbangan" class="form-label">Status Sumbangan <span class="text-danger">*</span></label>
        <select id="buku_sumbangan" name="buku_sumbangan" class="form-select @error('buku_sumbangan') is-invalid @enderror" required>
            @foreach (['Tidak', 'Ya'] as $donationStatus)
                <option value="{{ $donationStatus }}" @selected(old('buku_sumbangan', $book?->buku_sumbangan ?? 'Tidak') === $donationStatus)>{{ $donationStatus }}</option>
            @endforeach
        </select>
        @error('buku_sumbangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Batal</a>
    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>{{ $submitLabel }}</button>
</div>
