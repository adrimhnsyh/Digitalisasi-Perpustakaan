@extends('layouts.app')

@section('title', 'Peminjaman Baru')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Transaksi Baru</span><p>Pilih anggota dan maksimal {{ config('library.loan_max_items') }} koleksi yang tersedia.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a></div>
    </div>

    <form action="{{ route('admin.peminjaman.store') }}" method="POST" id="loan-form">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <strong>Transaksi belum dapat disimpan.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header"><strong>Data Peminjaman</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label for="anggota_id" class="form-label">Anggota <span class="text-danger">*</span></label>
                        <select id="anggota_id" name="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror" required>
                            <option value="">Pilih anggota</option>
                            @foreach ($anggota as $item)
                                <option value="{{ $item->no_anggota }}" @selected((string) old('anggota_id') === (string) $item->no_anggota)>[{{ $item->no_anggota }}] {{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('anggota_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input class="form-control" value="{{ $tanggalPinjam }}" readonly>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <label class="form-label">Batas Kembali</label>
                        <input class="form-control" value="{{ $tanggalKembali }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <strong>Koleksi yang Dipinjam</strong>
                <span class="text-muted small">Maksimal {{ config('library.loan_max_items') }} judul</span>
            </div>
            <div class="card-body">
                @php($bookInputs = old('buku_dipinjam') ?: [null])
                <div id="book-list">
                    @foreach ($bookInputs as $index => $selectedBook)
                        <div class="loan-book-row row g-2 align-items-end mb-3">
                            <div class="col-md">
                                <label class="form-label">Koleksi {{ $loop->iteration }} <span class="text-danger">*</span></label>
                                <select name="buku_dipinjam[{{ $index }}]" class="form-select @error('buku_dipinjam.'.$index) is-invalid @enderror" required>
                                    <option value="">Pilih koleksi tersedia</option>
                                    @foreach ($buku as $book)
                                        <option value="{{ $book->no_document }}" @selected((string) $selectedBook === (string) $book->no_document)>[{{ $book->no_document }}] {{ $book->judul }} - tersedia {{ $book->jumlah_tersedia }}</option>
                                    @endforeach
                                </select>
                                @error('buku_dipinjam.'.$index)<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-auto">
                                <button class="btn btn-outline-danger remove-book" type="button" aria-label="Hapus koleksi"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <template id="book-options-template">
                    <option value="">Pilih koleksi tersedia</option>
                    @foreach ($buku as $book)
                        <option value="{{ $book->no_document }}">[{{ $book->no_document }}] {{ $book->judul }} - tersedia {{ $book->jumlah_tersedia }}</option>
                    @endforeach
                </template>

                <button class="btn btn-outline-primary" type="button" id="add-book"><i class="fa-solid fa-plus me-2"></i>Tambah Koleksi</button>
            </div>
            <div class="card-footer bg-white d-flex justify-content-end gap-2 py-3">
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>Simpan Peminjaman</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        (() => {
            const list = document.getElementById('book-list');
            const addButton = document.getElementById('add-book');
            const form = document.getElementById('loan-form');
            const options = document.getElementById('book-options-template').innerHTML;
            const maximumBooks = {{ (int) config('library.loan_max_items') }};

            const syncRows = () => {
                const rows = [...list.querySelectorAll('.loan-book-row')];
                rows.forEach((row, index) => {
                    row.querySelector('label').innerHTML = 'Koleksi ' + (index + 1) + ' <span class="text-danger">*</span>';
                    row.querySelector('select').name = 'buku_dipinjam[' + index + ']';
                    row.querySelector('.remove-book').disabled = rows.length === 1;
                });
                addButton.disabled = rows.length >= maximumBooks;
            };

            addButton.addEventListener('click', () => {
                if (list.querySelectorAll('.loan-book-row').length >= maximumBooks) return;
                const row = document.createElement('div');
                row.className = 'loan-book-row row g-2 align-items-end mb-3';
                row.innerHTML = '<div class="col-md"><label class="form-label"></label><select class="form-select" required>' + options + '</select></div><div class="col-md-auto"><button class="btn btn-outline-danger remove-book" type="button" aria-label="Hapus koleksi"><i class="fa-solid fa-trash"></i></button></div>';
                list.append(row);
                syncRows();
            });

            list.addEventListener('click', (event) => {
                const removeButton = event.target.closest('.remove-book');
                if (removeButton && !removeButton.disabled) {
                    removeButton.closest('.loan-book-row').remove();
                    syncRows();
                }
            });

            form.addEventListener('submit', (event) => {
                const selected = new Set();
                let firstInvalid = null;
                list.querySelectorAll('select').forEach((select) => {
                    select.setCustomValidity('');
                    if (!select.value) {
                        select.setCustomValidity('Pilih koleksi yang akan dipinjam.');
                    } else if (selected.has(select.value)) {
                        select.setCustomValidity('Satu koleksi hanya dapat dipilih sekali.');
                    }
                    selected.add(select.value);
                    if (!select.validity.valid && !firstInvalid) firstInvalid = select;
                });
                if (firstInvalid) {
                    event.preventDefault();
                    firstInvalid.reportValidity();
                }
            });

            syncRows();
        })();
    </script>
@endpush
