@extends('layouts.public')

@section('title', 'Perpustakaan')
@section('description', 'Perpustakaan Politeknik STMI Jakarta untuk belajar, riset, dan berbagi pengetahuan.')

@section('content')
    @php
        $quickAccess = [
            ['label' => 'Katalog Koleksi', 'copy' => 'Cari buku dan cek ketersediaan', 'url' => route('catalog.index'), 'icon' => 'bi-search', 'external' => false],
            ['label' => 'Cek Peminjaman', 'copy' => 'Lihat tenggat dan riwayat Anda', 'url' => route('loan-status.index'), 'icon' => 'bi-person-check', 'external' => false],
            ['label' => 'Usulkan Buku', 'copy' => 'Sampaikan kebutuhan koleksi baru', 'url' => route('explore.index', ['type' => 'usulan_buku']).'#hubungi', 'icon' => 'bi-bookmark-plus', 'external' => false],
        ];

        $services = [
            ['number' => '01', 'title' => 'Sirkulasi', 'copy' => 'Peminjaman, pengembalian, dan perpanjangan koleksi dengan alur yang jelas.', 'icon' => 'bi-arrow-left-right', 'url' => route('tampilan.layanan')],
            ['number' => '02', 'title' => 'Referensi & Riset', 'copy' => 'Bantuan penelusuran sumber, jurnal, tugas akhir, dan literatur akademik.', 'icon' => 'bi-compass', 'url' => route('tampilan.layanan')],
            ['number' => '03', 'title' => 'Sumber Digital', 'copy' => 'Akses katalog, repository, jurnal nasional, dan database internasional.', 'icon' => 'bi-globe2', 'url' => route('e-resources')],
        ];
    @endphp

    <main>
        <section class="library-hero">
            <div class="library-hero__pattern" aria-hidden="true"></div>
            <div class="container position-relative">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="hero-copy">
                            <p class="hero-kicker"><span></span> Perpustakaan Politeknik STMI Jakarta</p>
                            <h1>Tempat ide tumbuh dan <em>pengetahuan</em> bertemu.</h1>
                            <p class="hero-lead">Koleksi, ruang belajar, dan sumber digital untuk membantu setiap langkah perjalanan akademik Anda.</p>
                            <form action="{{ route('catalog.index') }}" method="GET" class="hero-catalog-search" role="search">
                                <i class="bi bi-search" aria-hidden="true"></i>
                                <label class="visually-hidden" for="hero-catalog-query">Cari koleksi</label>
                                <input id="hero-catalog-query" name="q" type="search" inputmode="search" enterkeyhint="search" autocomplete="off" placeholder="Cari judul, penulis, subjek, atau topik...">
                                <button type="submit">Cari</button>
                            </form>
                            <div class="hero-actions">
                                <a href="{{ route('e-resources') }}" class="button button--light">Jelajahi E-Resources <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                                <a href="#layanan-mandiri" class="button button--ghost">Layanan mandiri</a>
                            </div>
                            <div class="hero-note">
                                <span class="hero-note__icon"><i class="bi {{ $libraryStatus['is_open'] ? 'bi-unlock' : 'bi-clock' }}" aria-hidden="true"></i></span>
                                <span><strong>{{ $libraryStatus['label'] }}</strong><small>{{ $libraryStatus['detail'] }}</small></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-visual" aria-label="Suasana Perpustakaan Politeknik STMI Jakarta">
                            <div class="hero-visual__halo" aria-hidden="true"></div>
                            <figure class="hero-photo hero-photo--main">
                                <img src="{{ asset('images/slideshow/1.png') }}" alt="Mahasiswa belajar di Perpustakaan Politeknik STMI Jakarta" width="1500" height="1001" loading="eager" fetchpriority="high" decoding="async">
                            </figure>
                            <figure class="hero-photo hero-photo--secondary">
                                <img src="{{ asset('images/slideshow/3.png') }}" alt="Koleksi buku Perpustakaan Politeknik STMI Jakarta" width="1500" height="1001" loading="lazy" decoding="async">
                            </figure>
                            <div class="hero-badge">
                                <span><i class="bi bi-book-half" aria-hidden="true"></i></span>
                                <p><strong>Sejak 1975</strong><small>Tumbuh bersama kampus</small></p>
                            </div>
                            <div class="hero-caption"><span></span> Ruang baca lantai 4</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="quick-access" id="layanan-mandiri" aria-label="Layanan mandiri">
            <div class="container">
                <div class="quick-access__panel">
                    <div class="quick-access__heading">
                        <span>Layanan mandiri</span>
                        <strong>Gunakan langsung</strong>
                    </div>
                    @foreach ($quickAccess as $item)
                        <a class="quick-access__item" href="{{ $item['url'] }}" @unless(($item['external'] ?? true) === false) target="_blank" rel="noopener noreferrer" @endunless>
                            <span class="quick-access__icon"><i class="bi {{ $item['icon'] }}" aria-hidden="true"></i></span>
                            <span class="quick-access__copy"><strong>{{ $item['label'] }}</strong><small>{{ $item['copy'] }}</small></span>
                            <i class="bi bi-arrow-up-right quick-access__arrow" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="home-statistics" aria-label="Statistik perpustakaan">
            <div class="container">
                <div class="home-statistics__grid">
                    <div><strong data-count="{{ $stats['titles'] }}">{{ number_format($stats['titles']) }}</strong><span>Judul koleksi</span></div>
                    <div><strong data-count="{{ $stats['copies'] }}">{{ number_format($stats['copies']) }}</strong><span>Total eksemplar</span></div>
                    <div><strong data-count="{{ $stats['available'] }}">{{ number_format($stats['available']) }}</strong><span>Siap dipinjam</span></div>
                    <div><strong data-count="{{ $stats['members'] }}">{{ number_format($stats['members']) }}</strong><span>Anggota aktif</span></div>
                </div>
            </div>
        </section>

        <section class="home-section home-intro">
            <div class="container">
                <div class="row align-items-end g-4 mb-5">
                    <div class="col-lg-7">
                        <p class="section-kicker">Lebih dari sekadar rak buku</p>
                        <h2 class="display-heading">Ruang yang mendekatkan Anda dengan informasi.</h2>
                    </div>
                    <div class="col-lg-5">
                        <p class="section-copy mb-0">Kami membantu sivitas akademika menemukan sumber terpercaya, menggunakan fasilitas belajar, dan mengembangkan kemampuan literasi informasi.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <article class="value-card value-card--blue">
                            <span class="value-card__icon"><i class="bi bi-collection" aria-hidden="true"></i></span>
                            <h3>Koleksi relevan</h3>
                            <p>Buku, jurnal, referensi, dan tugas akhir yang mendukung kurikulum serta penelitian.</p>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="value-card value-card--gold">
                            <span class="value-card__icon"><i class="bi bi-laptop" aria-hidden="true"></i></span>
                            <h3>Akses tanpa batas ruang</h3>
                            <p>Portal digital kampus dan database ilmiah yang dapat dijelajahi untuk kebutuhan riset.</p>
                        </article>
                    </div>
                    <div class="col-md-4">
                        <article class="value-card value-card--teal">
                            <span class="value-card__icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                            <h3>Ruang untuk bertumbuh</h3>
                            <p>Lingkungan nyaman untuk membaca, berdiskusi, menyusun karya, dan menemukan ide baru.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section collection-preview">
            <div class="container">
                <div class="section-heading-row">
                    <div>
                        <p class="section-kicker">Baru di perpustakaan</p>
                        <h2 class="display-heading">Koleksi terbaru untuk dijelajahi.</h2>
                    </div>
                    <a href="{{ route('catalog.index') }}" class="text-link d-none d-md-inline-flex">Buka katalog <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>

                @if ($latestBooks->isNotEmpty())
                    <div class="book-grid">
                        @foreach ($latestBooks as $book)
                            <x-public.book-card :book="$book" />
                        @endforeach
                    </div>
                @else
                    <div class="empty-public-state"><i class="bi bi-bookshelf"></i><p>Koleksi terbaru akan tampil setelah data buku ditambahkan.</p></div>
                @endif
                <a href="{{ route('catalog.index') }}" class="text-link d-md-none mt-4">Buka katalog <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
        </section>

        <section class="home-section study-paths">
            <div class="container">
                <div class="row g-4 align-items-end mb-5">
                    <div class="col-lg-7"><p class="section-kicker">Jelajahi berdasarkan program studi</p><h2 class="display-heading">Sumber yang dekat dengan bidang Anda.</h2></div>
                    <div class="col-lg-5"><p class="section-copy mb-0">Koleksi dikelompokkan melalui analisis judul, subjek, dan abstrak agar penelusuran lebih relevan.</p></div>
                </div>
                <div class="study-paths__grid">
                    @foreach ($classifications as $classification)
                        <a href="{{ route('catalog.index', ['classification' => $classification->id]) }}" class="study-path" style="--path-color:{{ $classification->warna }}">
                            <span class="study-path__icon"><i class="bi {{ $classification->ikon }}" aria-hidden="true"></i></span>
                            <span><strong>{{ $classification->kode }}</strong><small>{{ $classification->nama }}</small></span>
                            <em>{{ number_format($classification->buku_count) }}</em>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="home-section library-story">
            <div class="container">
                <div class="row align-items-center g-5 g-xl-6">
                    <div class="col-lg-6">
                        <div class="story-visual">
                            <div class="story-visual__shape" aria-hidden="true"></div>
                            <img class="story-visual__image" src="{{ asset('images/ISI PERPUS (1).jpg') }}" alt="Area belajar Perpustakaan Politeknik STMI Jakarta" width="4032" height="2268" loading="lazy" decoding="async">
                            <div class="story-visual__card">
                                <span>1975</span>
                                <p>Hadir mendampingi pendidikan industri di Indonesia.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="story-copy">
                            <p class="section-kicker">Tentang perpustakaan</p>
                            <h2 class="display-heading">Mendampingi proses belajar dari awal hingga karya akhir.</h2>
                            <p class="section-copy">Perpustakaan menjadi bagian dari ekosistem akademik Politeknik STMI Jakarta, mulai dari membantu menemukan buku hingga menelusuri referensi untuk penelitian.</p>
                            <ul class="story-points">
                                <li><span><i class="bi bi-check2" aria-hidden="true"></i></span> Dukungan pencarian informasi dan referensi</li>
                                <li><span><i class="bi bi-check2" aria-hidden="true"></i></span> Akses koleksi fisik dan sumber elektronik</li>
                                <li><span><i class="bi bi-check2" aria-hidden="true"></i></span> Layanan untuk kebutuhan tugas akhir</li>
                            </ul>
                            <a href="{{ route('tampilan.sejarah') }}" class="text-link">Kenali perjalanan kami <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section services-showcase">
            <div class="container">
                <div class="section-heading-row">
                    <div>
                        <p class="section-kicker">Layanan utama</p>
                        <h2 class="display-heading">Dukungan yang Anda butuhkan.</h2>
                    </div>
                    <a href="{{ route('tampilan.layanan') }}" class="text-link d-none d-md-inline-flex">Lihat semua layanan <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>

                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ $service['url'] }}" class="service-card">
                                <div class="service-card__top">
                                    <span class="service-card__icon"><i class="bi {{ $service['icon'] }}" aria-hidden="true"></i></span>
                                    <span class="service-card__number">{{ $service['number'] }}</span>
                                </div>
                                <h3>{{ $service['title'] }}</h3>
                                <p>{{ $service['copy'] }}</p>
                                <span class="service-card__link">Pelajari layanan <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('tampilan.layanan') }}" class="text-link d-md-none mt-4">Lihat semua layanan <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
        </section>

        <section class="digital-callout">
            <div class="container">
                <div class="digital-callout__inner">
                    <div class="digital-callout__orb" aria-hidden="true"></div>
                    <div class="row align-items-center g-4 position-relative">
                        <div class="col-lg-8">
                            <p class="section-kicker section-kicker--light">Perpustakaan digital</p>
                            <h2>Belajar tidak berhenti ketika Anda meninggalkan ruang baca.</h2>
                            <p>Akses repository, jurnal, dan sumber riset pilihan dari satu halaman.</p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="{{ route('e-resources') }}" class="button button--light">Buka E-Resources <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-section home-updates">
            <div class="container">
                <div class="section-heading-row">
                    <div><p class="section-kicker">Kabar dan agenda</p><h2 class="display-heading">Yang sedang berlangsung.</h2></div>
                    <a href="{{ route('explore.index') }}#agenda" class="text-link d-none d-md-inline-flex">Lihat pusat informasi <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="row g-4">
                            @forelse($news as $item)
                                <div class="col-md-6 {{ $loop->first ? 'col-lg-7' : 'col-lg-5' }}">
                                    <a class="news-card" href="{{ route('public-content.show', $item) }}">
                                        <div class="news-card__image">@if($item->image_url)<img src="{{ $item->image_url }}" alt="" loading="lazy" decoding="async">@else<i class="bi bi-newspaper"></i>@endif</div>
                                        <div class="news-card__body"><span>{{ $item->type_label }}</span><h3>{{ $item->title }}</h3><p>{{ $item->excerpt }}</p></div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12"><div class="empty-public-state"><p>Berita terbaru akan segera hadir.</p></div></div>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="agenda-panel" id="agenda">
                            <div class="agenda-panel__header"><span>Agenda terdekat</span><i class="bi bi-calendar3"></i></div>
                            @forelse($events as $event)
                                <a href="{{ route('public-content.show', $event) }}" class="agenda-item">
                                    <time><strong>{{ $event->event_at?->format('d') ?? '--' }}</strong><span>{{ $event->event_at?->translatedFormat('M') ?? 'Info' }}</span></time>
                                    <span><strong>{{ $event->title }}</strong><small>{{ $event->event_at?->format('H.i') ? $event->event_at->format('H.i').' WIB' : 'Jadwal menyusul' }}</small></span>
                                </a>
                            @empty
                                <p class="small mb-0">Belum ada agenda mendatang.</p>
                            @endforelse
                            <a href="{{ route('explore.index') }}#agenda" class="agenda-panel__link">Semua agenda <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="partners-modern">
            <div class="container">
                <div class="partners-modern__heading">
                    <p class="section-kicker">Sumber informasi pilihan</p>
                    <h2>Terhubung dengan ekosistem riset.</h2>
                </div>
                <div class="partners-modern__grid">
                    <a href="{{ route('e-resources') }}" class="partner-logo" aria-label="SINTA"><img src="{{ asset('images/partners/sinta.png') }}" alt="SINTA" width="1110" height="1110" loading="lazy" decoding="async"></a>
                    <a href="{{ route('e-resources') }}" class="partner-logo" aria-label="Scopus"><img src="{{ asset('images/Scopus_logo.png') }}" alt="Scopus" width="960" height="309" loading="lazy" decoding="async"></a>
                    <a href="{{ route('e-resources') }}" class="partner-logo" aria-label="ScienceDirect"><img src="{{ asset('images/sciencedirect-logo.png') }}" alt="ScienceDirect" width="784" height="579" loading="lazy" decoding="async"></a>
                    <a href="{{ route('e-resources') }}" class="partner-logo" aria-label="Springer"><img src="{{ asset('images/Springer.jpg') }}" alt="Springer" width="259" height="194" loading="lazy" decoding="async"></a>
                </div>
            </div>
        </section>
    </main>
@endsection
