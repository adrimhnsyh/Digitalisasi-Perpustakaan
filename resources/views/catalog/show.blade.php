@extends('layouts.public')

@section('title', $buku->judul)
@section('description', \Illuminate\Support\Str::limit($buku->abstrak ?: $buku->resensi ?: 'Detail koleksi Perpustakaan Politeknik STMI Jakarta.', 150))

@section('content')
    <main>
        <section class="book-detail-hero">
            <div class="container">
                <nav class="book-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('catalog.index') }}">Katalog</a><i class="bi bi-chevron-right"></i><span>{{ $buku->kategori ?: 'Koleksi' }}</span></nav>
                <div class="row align-items-center g-5">
                    <div class="col-md-4 col-lg-3">
                        <div class="book-detail-cover" style="--book-color:{{ $buku->klasifikasi?->warna ?? '#1674c8' }}">
                            @if($buku->cover_url)<img src="{{ $buku->cover_url }}" alt="Sampul {{ $buku->judul }}">@else<span class="generated-cover"><small>{{ $buku->klasifikasi?->kode ?? 'STMI' }}</small><strong>{{ \Illuminate\Support\Str::limit($buku->judul, 52) }}</strong><em>Perpustakaan STMI</em></span>@endif
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="book-detail-heading">
                            <div class="book-detail-tags"><span>{{ $buku->kategori ?: 'Koleksi' }}</span>@if($buku->klasifikasi)<span style="--tag-color:{{ $buku->klasifikasi->warna }}">{{ $buku->klasifikasi->kode }} · {{ $buku->klasifikasi->nama }}</span>@endif</div>
                            <h1>{{ $buku->judul }}</h1>
                            <p class="book-detail-author">{{ $buku->penulis ?: $buku->penulis_badan ?: 'Penulis belum dicatat' }}</p>
                            <div class="book-availability {{ $buku->jumlah_tersedia > 0 ? 'is-available' : 'is-empty' }}"><span></span><strong>{{ $buku->jumlah_tersedia > 0 ? $buku->jumlah_tersedia.' eksemplar tersedia' : 'Seluruh eksemplar sedang dipinjam' }}</strong><small>dari {{ $buku->jumlah_dokumen }} eksemplar</small></div>
                            <div class="book-detail-actions">
                                @if($buku->external_url)<a href="{{ $buku->external_url }}" target="_blank" rel="noopener noreferrer" class="button catalog-filter__button">Buka sumber digital <i class="bi bi-arrow-up-right"></i></a>@endif
                                <a href="{{ route('explore.index') }}#hubungi" class="button button-outline-navy">Tanya pustakawan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="book-detail-content">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <article class="book-abstract-panel">
                            <p class="section-kicker">Tentang koleksi</p>
                            <h2>Abstrak</h2>
                            <div class="book-abstract">{{ $buku->abstrak ?: $buku->resensi ?: 'Abstrak untuk koleksi ini belum tersedia.' }}</div>
                            @if($buku->classification_keywords)
                                <div class="book-keywords"><strong>Topik terdeteksi</strong>@foreach($buku->classification_keywords as $keyword)<span>{{ $keyword }}</span>@endforeach</div>
                            @endif
                        </article>
                    </div>
                    <div class="col-lg-4">
                        <aside class="book-metadata-panel">
                            <h2>Informasi bibliografi</h2>
                            <dl>
                                <div><dt>Nomor dokumen</dt><dd>#{{ $buku->no_document }}</dd></div>
                                <div><dt>Kode panggil</dt><dd>{{ $buku->kode_panggil ?: '-' }}</dd></div>
                                <div><dt>Penerbit</dt><dd>{{ $buku->nama_penerbit ?: '-' }}</dd></div>
                                <div><dt>Tahun</dt><dd>{{ $buku->tahun_terbit ?: '-' }}</dd></div>
                                <div><dt>Bahasa</dt><dd>{{ $buku->bahasa_teks ?: '-' }}</dd></div>
                                <div><dt>Lokasi</dt><dd>{{ $buku->lokasi_dokumen ?: '-' }}</dd></div>
                                <div><dt>Deskripsi</dt><dd>{{ $buku->deskripsi_fisik ?: '-' }}</dd></div>
                            </dl>
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        @if($relatedBooks->isNotEmpty())
            <section class="related-books"><div class="container"><div class="section-heading-row"><div><p class="section-kicker">Masih satu bidang</p><h2 class="display-heading">Koleksi terkait.</h2></div></div><div class="book-grid book-grid--four">@foreach($relatedBooks as $book)<x-public.book-card :book="$book" />@endforeach</div></div></section>
        @endif
    </main>
@endsection
