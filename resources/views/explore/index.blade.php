@extends('layouts.public')

@section('title', 'Pusat Eksplorasi')
@section('description', 'Panduan riset, program studi, agenda, galeri, FAQ, dan layanan interaktif Perpustakaan Politeknik STMI Jakarta.')

@section('content')
    @php
        $guides = $content->get('panduan', collect());
        $events = $content->get('agenda', collect());
        $works = $content->get('karya', collect());
        $challenges = $content->get('tantangan', collect());
        $faqs = $content->get('faq', collect());
        $profiles = $content->get('profil', collect());
        $downloads = $content->get('unduhan', collect());
        $toolkits = [
            ['title' => 'Google Scholar', 'copy' => 'Temukan literatur akademik lintas disiplin.', 'icon' => 'bi-mortarboard', 'url' => 'https://scholar.google.com'],
            ['title' => 'SINTA', 'copy' => 'Telusuri jurnal, penulis, dan kinerja riset Indonesia.', 'icon' => 'bi-bar-chart', 'url' => 'https://sinta.kemdikbud.go.id'],
            ['title' => 'Mendeley', 'copy' => 'Kelola referensi dan sitasi penelitian.', 'icon' => 'bi-bookmark-check', 'url' => 'https://www.mendeley.com'],
            ['title' => 'Zotero', 'copy' => 'Simpan sumber dan susun daftar pustaka.', 'icon' => 'bi-collection', 'url' => 'https://www.zotero.org'],
        ];
        $thesisSteps = [
            ['title' => 'Tentukan fokus', 'copy' => 'Uraikan masalah dan kata kunci utama penelitian.'],
            ['title' => 'Telusuri referensi', 'copy' => 'Cari buku, jurnal, dan karya terdahulu dari sumber terpercaya.'],
            ['title' => 'Kelola sitasi', 'copy' => 'Gunakan aplikasi referensi dan catat seluruh sumber sejak awal.'],
            ['title' => 'Cek orisinalitas', 'copy' => 'Tinjau kutipan dan hasil Turnitin sesuai ketentuan kampus.'],
            ['title' => 'Unggah karya', 'copy' => 'Lengkapi repository dan administrasi bebas perpustakaan.'],
        ];
    @endphp

    <main>
        <section class="explore-hero">
            <div class="explore-hero__pattern" aria-hidden="true"></div>
            <div class="container position-relative">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7">
                        <p class="hero-kicker"><span></span>Pusat Eksplorasi</p>
                        <h1>Semua yang Anda perlukan untuk belajar dan meneliti.</h1>
                        <p>Panduan, alat riset, rekomendasi, agenda, dan layanan perpustakaan dalam satu halaman.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="explore-hero__menu">
                            <a href="#prodi"><i class="bi bi-diagram-3"></i><span>Koleksi per prodi</span></a>
                            <a href="#tugas-akhir"><i class="bi bi-journal-check"></i><span>Pojok tugas akhir</span></a>
                            <a href="#tur"><i class="bi bi-map"></i><span>Tur perpustakaan</span></a>
                            <a href="#hubungi"><i class="bi bi-chat-square-text"></i><span>Hubungi pustakawan</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <nav class="explore-anchor-nav" aria-label="Navigasi halaman eksplorasi">
            <div class="container"><a href="#wrapped">Library Wrapped</a><a href="#prodi">Program Studi</a><a href="#rekomendasi">Rekomendasi</a><a href="#tugas-akhir">Tugas Akhir</a><a href="#agenda">Agenda</a><a href="#tur">Galeri</a><a href="#faq">FAQ</a><a href="#hubungi">Layanan</a></div>
        </nav>

        <section class="explore-section wrapped-section" id="wrapped">
            <div class="container">
                <div class="wrapped-card">
                    <div class="wrapped-card__intro"><span>{{ now()->year }}</span><p class="section-kicker section-kicker--light">Library Wrapped</p><h2>Jejak pengetahuan tahun ini.</h2><p>Gambaran singkat aktivitas dan kesiapan koleksi perpustakaan.</p></div>
                    <div class="wrapped-card__stats">
                        <div><strong data-count="{{ $wrapped['collections'] }}">{{ number_format($wrapped['collections']) }}</strong><span>Judul koleksi</span></div>
                        <div><strong data-count="{{ $wrapped['available'] }}">{{ number_format($wrapped['available']) }}</strong><span>Eksemplar tersedia</span></div>
                        <div><strong data-count="{{ $wrapped['loans_this_year'] }}">{{ number_format($wrapped['loans_this_year']) }}</strong><span>Transaksi tahun ini</span></div>
                        <div><strong data-count="{{ $wrapped['items_this_year'] }}">{{ number_format($wrapped['items_this_year']) }}</strong><span>Item dipinjam</span></div>
                    </div>
                    @if($mostPopular)<div class="wrapped-card__popular"><span>Paling sering dipinjam</span><strong>{{ $mostPopular->judul }}</strong><small>{{ number_format($mostPopular->total_dipinjam ?? 0) }} kali tercatat</small></div>@endif
                </div>
            </div>
        </section>

        <section class="explore-section" id="prodi">
            <div class="container">
                <div class="section-heading-row"><div><p class="section-kicker">Jelajahi berdasarkan prodi</p><h2 class="display-heading">Masuk melalui bidang yang Anda kenal.</h2></div><a href="{{ route('catalog.index') }}" class="text-link d-none d-md-inline-flex">Semua koleksi <i class="bi bi-arrow-right"></i></a></div>
                <div class="program-grid">
                    @foreach($classifications as $classification)
                        <a href="{{ route('catalog.index', ['classification' => $classification->id]) }}" class="program-card" style="--program-color:{{ $classification->warna }}">
                            <div class="program-card__top"><span><i class="bi {{ $classification->ikon }}"></i></span><em>{{ $classification->kode }}</em></div>
                            <h3>{{ $classification->nama }}</h3><p>{{ $classification->deskripsi }}</p><div><strong>{{ number_format($classification->buku_count) }}</strong> koleksi <i class="bi bi-arrow-right"></i></div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="explore-section curated-section" id="rekomendasi">
            <div class="container">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-4">
                        <p class="section-kicker">Rekomendasi pustakawan</p><h2 class="display-heading">Pilihan yang layak dibuka berikutnya.</h2><p class="section-copy mt-3">Kurasi koleksi untuk menemukan topik penting, sumber pengantar, dan bacaan yang banyak digunakan.</p>
                    </div>
                    <div class="col-lg-8">
                        @if($staffPicks->isNotEmpty())<div class="book-grid book-grid--compact">@foreach($staffPicks as $book)<x-public.book-card :book="$book" />@endforeach</div>@else<div class="empty-public-state"><i class="bi bi-bookmark-star"></i><p>Rekomendasi pustakawan akan tampil setelah dipilih melalui admin.</p></div>@endif
                    </div>
                </div>
            </div>
        </section>

        <section class="explore-section thesis-corner" id="tugas-akhir">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-7">
                        <p class="section-kicker">Pojok tugas akhir</p><h2 class="display-heading">Dari pertanyaan pertama hingga repository.</h2>
                        <div class="thesis-steps">@foreach($thesisSteps as $step)<div class="thesis-step"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div><h3>{{ $step['title'] }}</h3><p>{{ $step['copy'] }}</p></div></div>@endforeach</div>
                    </div>
                    <div class="col-lg-5">
                        <aside class="research-toolkit"><div class="research-toolkit__heading"><span><i class="bi bi-tools"></i></span><div><p>Research Toolkit</p><h2>Alat bantu penelitian</h2></div></div><div class="research-toolkit__list">@foreach($toolkits as $tool)<a href="{{ $tool['url'] }}" target="_blank" rel="noopener noreferrer"><i class="bi {{ $tool['icon'] }}"></i><span><strong>{{ $tool['title'] }}</strong><small>{{ $tool['copy'] }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div><a href="{{ route('e-resources') }}" class="button button--light w-100 mt-4">Jelajahi E-Resources</a></aside>
                    </div>
                </div>
                @if($guides->isNotEmpty())<div class="quick-guide-grid">@foreach($guides as $guide)<a href="{{ route('public-content.show', $guide) }}" class="quick-guide"><span><i class="bi bi-signpost-split"></i></span><div><small>Panduan cepat</small><h3>{{ $guide->title }}</h3><p>{{ $guide->excerpt }}</p></div><i class="bi bi-arrow-right"></i></a>@endforeach</div>@endif
            </div>
        </section>

        <section class="explore-section agenda-section" id="agenda">
            <div class="container">
                <div class="section-heading-row"><div><p class="section-kicker">Agenda dan komunitas</p><h2 class="display-heading">Belajar juga terjadi bersama.</h2></div></div>
                <div class="row g-4">
                    <div class="col-lg-7"><div class="event-list">@forelse($events as $event)<a href="{{ route('public-content.show', $event) }}" class="event-card"><time><strong>{{ $event->event_at?->format('d') ?? '--' }}</strong><span>{{ $event->event_at?->translatedFormat('M Y') ?? 'Agenda' }}</span></time><div><span>{{ $event->event_at?->format('H.i') ? $event->event_at->format('H.i').' WIB' : 'Jadwal menyusul' }}</span><h3>{{ $event->title }}</h3><p>{{ $event->excerpt }}</p></div><i class="bi bi-arrow-right"></i></a>@empty<div class="empty-public-state"><p>Belum ada agenda terjadwal.</p></div>@endforelse</div></div>
                    <div class="col-lg-5">
                        @if($challenges->isNotEmpty())
                            @foreach($challenges as $challenge)
                                <a href="{{ route('public-content.show', $challenge) }}" class="challenge-card">
                                    <span class="challenge-card__label">Reading Challenge</span><i class="bi bi-trophy"></i>
                                    <h3>{{ $challenge->title }}</h3><p>{{ $challenge->excerpt }}</p>
                                    @if($challenge->event_end_at)
                                        <small>Berakhir {{ $challenge->event_end_at->translatedFormat('d F Y') }}</small>
                                    @endif
                                    <strong>Ikuti tantangan <i class="bi bi-arrow-right"></i></strong>
                                </a>
                            @endforeach
                        @endif
                        @if($works->isNotEmpty())
                            @foreach($works as $work)
                                <a href="{{ route('public-content.show', $work) }}" class="student-work-card">
                                    <span><i class="bi bi-lightbulb"></i></span>
                                    <div><small>Student Research Spotlight</small><h3>{{ $work->title }}</h3><p>{{ $work->excerpt }}</p></div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="explore-section tour-section" id="tur">
            <div class="container">
                <div class="row align-items-end g-4 mb-5"><div class="col-lg-7"><p class="section-kicker">Virtual tour</p><h2 class="display-heading">Kenali ruang sebelum berkunjung.</h2></div><div class="col-lg-5"><p class="section-copy mb-0">Lihat suasana area baca, koleksi, komputer katalog, dan fasilitas yang dapat digunakan.</p></div></div>
                <div class="tour-gallery">@foreach($gallery as $image)<figure class="tour-gallery__item tour-gallery__item--{{ ($loop->index % 5) + 1 }}"><img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" loading="lazy"></figure>@endforeach</div>
                <div class="library-map">
                    <div class="library-map__heading"><p class="section-kicker">Panduan zona</p><h2>Peta fasilitas utama</h2><span>Gedung A · Lantai 4</span></div>
                    <div class="library-map__plan" aria-label="Ilustrasi zona fasilitas perpustakaan">
                        <div class="map-zone map-zone--entrance"><i class="bi bi-door-open"></i><span>Pintu masuk</span></div>
                        <div class="map-zone map-zone--service"><i class="bi bi-person-workspace"></i><span>Meja layanan</span></div>
                        <div class="map-zone map-zone--catalog"><i class="bi bi-pc-display"></i><span>Komputer katalog</span></div>
                        <div class="map-zone map-zone--shelves"><i class="bi bi-bookshelf"></i><span>Rak koleksi</span></div>
                        <div class="map-zone map-zone--reading"><i class="bi bi-lamp"></i><span>Area baca</span></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="explore-section information-hub">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="information-column"><div class="information-column__heading"><i class="bi bi-people"></i><span><small>Temui kami</small><h2>Tim pustakawan</h2></span></div>@forelse($profiles as $profile)<a href="{{ route('public-content.show', $profile) }}" class="information-row"><span>{{ $profile->title }}</span><i class="bi bi-arrow-right"></i></a>@empty<p class="small">Profil tim akan segera tersedia.</p>@endforelse</div>
                    </div>
                    <div class="col-lg-4">
                        <div class="information-column"><div class="information-column__heading"><i class="bi bi-download"></i><span><small>Dokumen penting</small><h2>Unduhan</h2></span></div>@forelse($downloads as $download)<a href="{{ $download->attachment_url ?: (str_starts_with($download->external_url ?? '', '/') ? url($download->external_url) : $download->external_url) ?: route('public-content.show', $download) }}" class="information-row"><span>{{ $download->title }}</span><i class="bi bi-download"></i></a>@empty<p class="small">Belum ada dokumen unduhan.</p>@endforelse</div>
                    </div>
                    <div class="col-lg-4">
                        <a href="{{ route('loan-status.index') }}" class="member-service-card"><i class="bi bi-person-vcard"></i><span>Layanan anggota</span><h2>Cek tenggat dan riwayat peminjaman.</h2><p>Verifikasi dengan data anggota tanpa perlu akun tambahan.</p><strong>Buka layanan <i class="bi bi-arrow-right"></i></strong></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="explore-section faq-section" id="faq">
            <div class="container"><div class="row g-5"><div class="col-lg-4"><p class="section-kicker">Pertanyaan umum</p><h2 class="display-heading">Jawaban yang sering dibutuhkan.</h2><p class="section-copy mt-3">Jika jawaban belum ditemukan, kirim pertanyaan langsung kepada pustakawan.</p></div><div class="col-lg-8"><div class="accordion public-faq" id="public-faq">@forelse($faqs as $faq)<div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">{{ $faq->title }}</button></h3><div id="faq-{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#public-faq"><div class="accordion-body">{{ $faq->body }}</div></div></div>@empty<div class="empty-public-state"><p>FAQ akan segera tersedia.</p></div>@endforelse</div></div></div></div>
        </section>

        <section class="explore-section contact-library" id="hubungi">
            <div class="container">
                <div class="contact-library__shell">
                    <div class="row g-5">
                        <div class="col-lg-5"><p class="section-kicker section-kicker--light">Terhubung dengan perpustakaan</p><h2>Punya kebutuhan yang belum terjawab?</h2><p>Usulkan buku, tanyakan referensi, kirim aspirasi, atau daftar tantangan baca. Semua pesan masuk langsung ke dashboard admin.</p><div class="contact-library__types"><span><i class="bi bi-bookmark-plus"></i>Usulan buku</span><span><i class="bi bi-chat-dots"></i>Tanya pustakawan</span><span><i class="bi bi-lightbulb"></i>Aspirasi</span><span><i class="bi bi-trophy"></i>Tantangan baca</span></div></div>
                        <div class="col-lg-7">
                            <form action="{{ route('public-request.store') }}" method="POST" class="public-request-form">
                                @csrf
                                @if(session('request_success'))<div class="alert alert-success">{{ session('request_success') }}</div>@endif
                                @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                                <div class="row g-3">
                                    <div class="col-md-6"><label for="request-type">Jenis layanan</label><select id="request-type" name="type" required>@foreach(\App\Models\PermintaanPublik::TYPES as $value => $label)<option value="{{ $value }}" @selected(old('type', request('type')) === $value)>{{ $label }}</option>@endforeach</select></div>
                                    <div class="col-md-6"><label for="request-name">Nama</label><input id="request-name" name="name" value="{{ old('name') }}" required></div>
                                    <div class="col-md-6"><label for="request-email">Email</label><input id="request-email" type="email" name="email" value="{{ old('email') }}"></div>
                                    <div class="col-md-6"><label for="request-phone">Telepon</label><input id="request-phone" name="phone" value="{{ old('phone') }}"></div>
                                    <div class="col-md-6"><label for="request-member">Nomor anggota (opsional)</label><input id="request-member" name="member_number" value="{{ old('member_number') }}"></div>
                                    <div class="col-md-6"><label for="request-subject">Subjek / Judul buku</label><input id="request-subject" name="subject" value="{{ old('subject') }}" required></div>
                                    <div class="col-12"><label for="request-message">Pesan</label><textarea id="request-message" name="message" rows="5" required>{{ old('message') }}</textarea></div>
                                    <div class="col-12"><button class="button button--light" type="submit">Kirim ke Perpustakaan <i class="bi bi-send"></i></button><small>Isi minimal salah satu kontak: email atau telepon.</small></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
