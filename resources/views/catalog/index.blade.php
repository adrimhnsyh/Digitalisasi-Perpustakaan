@extends('layouts.public')

@section('title', 'Katalog Koleksi')
@section('description', 'Cari dan jelajahi koleksi Perpustakaan Politeknik STMI Jakarta.')

@section('content')
    <main>
        <section class="page-hero catalog-hero">
            <div class="container">
                <p class="eyebrow mb-2">Katalog Terpadu</p>
                <h1 class="page-title mb-3">Temukan koleksi yang tepat.</h1>
                <p class="mb-0">Cari berdasarkan judul, penulis, subjek, atau isi abstrak dan lihat ketersediaannya secara langsung.</p>
            </div>
        </section>

        <section class="catalog-section">
            <div class="container">
                <form action="{{ route('catalog.index') }}" method="GET" class="catalog-filter" role="search">
                    <div class="catalog-filter__search">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <label class="visually-hidden" for="catalog-query">Cari koleksi</label>
                        <input id="catalog-query" name="q" value="{{ $search }}" placeholder="Judul, penulis, subjek, abstrak...">
                    </div>
                    <div>
                        <label class="visually-hidden" for="catalog-classification">Program studi</label>
                        <select id="catalog-classification" name="classification">
                            <option value="">Semua bidang</option>
                            @foreach($classifications as $item)<option value="{{ $item->id }}" @selected($classification === $item->id)>{{ $item->kode }} · {{ $item->nama }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="visually-hidden" for="catalog-type">Jenis</label>
                        <select id="catalog-type" name="type"><option value="">Semua jenis</option>@foreach(['Buku','Jurnal','Tugas Akhir'] as $itemType)<option value="{{ $itemType }}" @selected($type === $itemType)>{{ $itemType }}</option>@endforeach</select>
                    </div>
                    <div>
                        <label class="visually-hidden" for="catalog-availability">Ketersediaan</label>
                        <select id="catalog-availability" name="availability"><option value="">Semua status</option><option value="available" @selected($availability === 'available')>Tersedia</option><option value="borrowed" @selected($availability === 'borrowed')>Sedang dipinjam</option></select>
                    </div>
                    <button type="submit" class="button catalog-filter__button">Terapkan</button>
                </form>

                <div class="catalog-result-heading">
                    <div><span>Hasil pencarian</span><h2>{{ number_format($books->total()) }} koleksi ditemukan</h2></div>
                    @if($search !== '' || $classification || $type !== '' || $availability !== '')<a href="{{ route('catalog.index') }}">Hapus filter <i class="bi bi-x-lg"></i></a>@endif
                </div>

                @if($books->isNotEmpty())
                    <div class="book-grid catalog-book-grid">
                        @foreach($books as $book)<x-public.book-card :book="$book" />@endforeach
                    </div>
                    @if($books->hasPages())<div class="public-pagination">{{ $books->links('pagination::bootstrap-5') }}</div>@endif
                @else
                    <div class="empty-public-state empty-public-state--large"><i class="bi bi-search"></i><h2>Koleksi belum ditemukan</h2><p>Coba gunakan kata yang lebih singkat atau hapus beberapa filter.</p><a class="button catalog-filter__button" href="{{ route('catalog.index') }}">Lihat semua koleksi</a></div>
                @endif
            </div>
        </section>
    </main>
@endsection
