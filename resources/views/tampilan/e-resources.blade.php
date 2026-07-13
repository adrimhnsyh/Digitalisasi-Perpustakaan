@extends('layouts.public')

@section('title', 'E-Resources')

@section('content')
    @php
        $stmiResources = [
            ['name' => 'Katalog Online', 'description' => 'Cari buku, jurnal, dan materi perpustakaan Politeknik STMI Jakarta.', 'url' => 'https://lib.stmi.ac.id', 'icon' => 'fa-magnifying-glass'],
            ['name' => 'Jurnal STMI', 'description' => 'Portal jurnal penelitian dan publikasi ilmiah Politeknik STMI Jakarta.', 'url' => 'https://jurnal.stmi.ac.id', 'icon' => 'fa-book-journal-whills'],
            ['name' => 'Repository STMI', 'description' => 'Akses tugas akhir, penelitian, dan karya ilmiah sivitas akademika STMI.', 'url' => 'https://repository.stmi.ac.id', 'icon' => 'fa-box-archive'],
        ];
        $internationalResources = [
            ['name' => 'Emerald Publishing', 'description' => 'Jurnal internasional bidang bisnis, manajemen, ekonomi, dan ilmu sosial.', 'url' => 'https://www.emerald.com', 'icon' => 'fa-chart-line'],
            ['name' => 'ACS Publications', 'description' => 'Jurnal kimia, sains, dan teknologi dari American Chemical Society.', 'url' => 'https://pubs.acs.org', 'icon' => 'fa-flask'],
            ['name' => 'ScienceDirect', 'description' => 'Database riset Elsevier lintas disiplin.', 'url' => 'https://www.sciencedirect.com', 'icon' => 'fa-atom'],
            ['name' => 'Scopus', 'description' => 'Database abstrak dan sitasi untuk kebutuhan riset.', 'url' => 'https://www.scopus.com', 'icon' => 'fa-arrow-trend-up'],
            ['name' => 'Springer', 'description' => 'Jurnal dan buku ilmiah internasional.', 'url' => 'https://www.springer.com', 'icon' => 'fa-globe'],
            ['name' => 'Nature Communications', 'description' => 'Jurnal multidisiplin dan hasil riset terpilih.', 'url' => 'https://www.nature.com/ncomms', 'icon' => 'fa-lightbulb'],
        ];
        $nationalResources = [
            ['name' => 'SINTA', 'description' => 'Science and Technology Index dari Kemendikbud.', 'url' => 'https://sinta.kemdikbud.go.id'],
            ['name' => 'GARUDA', 'description' => 'Garba Rujukan Digital Indonesia.', 'url' => 'https://garuda.kemdikbud.go.id'],
            ['name' => 'Google Scholar', 'description' => 'Mesin pencari literatur akademik.', 'url' => 'https://scholar.google.com'],
            ['name' => 'Neliti', 'description' => 'Repositori riset Indonesia.', 'url' => 'https://www.neliti.com'],
        ];
    @endphp

    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Sumber Digital</p>
                <h1 class="page-title mb-2">E-Resources</h1>
                <p class="mb-0 opacity-75">Portal digital untuk mendukung pembelajaran, penelusuran, dan penelitian Anda.</p>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="mb-5">
                    <p class="section-label">Sistem STMI</p>
                    <h2 class="section-heading">Mulai dari sumber kampus.</h2>
                </div>
                <div class="row g-4">
                    @foreach ($stmiResources as $resource)
                        <div class="col-md-6 col-lg-4">
                            <article class="resource-card p-4 h-100 d-flex flex-column">
                                <span class="quick-icon mb-4"><i class="fa-solid {{ $resource['icon'] }}"></i></span>
                                <h3 class="h5">{{ $resource['name'] }}</h3>
                                <p class="text-muted small">{{ $resource['description'] }}</p>
                                <a class="fw-bold text-decoration-none mt-auto" href="{{ $resource['url'] }}" target="_blank" rel="noopener noreferrer">Buka sumber <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i></a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-space pt-0">
            <div class="container">
                <div class="soft-panel p-4 p-lg-5">
                    <p class="section-label">Portal Nasional</p>
                    <h2 class="section-heading">Temukan riset dari Indonesia.</h2>
                    <div class="row g-3 mt-1">
                        @foreach ($nationalResources as $resource)
                            <div class="col-md-6 col-lg-3">
                                <a href="{{ $resource['url'] }}" target="_blank" rel="noopener noreferrer" class="quick-card d-block text-decoration-none">
                                    <h3 class="h6">{{ $resource['name'] }}</h3>
                                    <p class="text-muted small mb-0">{{ $resource['description'] }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="section-space pt-0">
            <div class="container">
                <div class="mb-5">
                    <p class="section-label">Database Internasional</p>
                    <h2 class="section-heading">Perluas perspektif riset Anda.</h2>
                </div>
                <div class="row g-4">
                    @foreach ($internationalResources as $resource)
                        <div class="col-md-6 col-lg-4">
                            <article class="resource-card p-4 h-100 d-flex flex-column">
                                <span class="quick-icon mb-4"><i class="fa-solid {{ $resource['icon'] }}"></i></span>
                                <h3 class="h5">{{ $resource['name'] }}</h3>
                                <p class="text-muted small">{{ $resource['description'] }}</p>
                                <a class="fw-bold text-decoration-none mt-auto" href="{{ $resource['url'] }}" target="_blank" rel="noopener noreferrer">Kunjungi portal <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i></a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
