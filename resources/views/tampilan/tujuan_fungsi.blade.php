@extends('layouts.public')

@section('title', 'Tujuan dan Fungsi')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Tentang Perpustakaan</p>
                <h1 class="page-title mb-0">Tujuan dan Fungsi</h1>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <article class="content-card h-100">
                            <p class="section-label">Tujuan</p>
                            <h2 class="section-heading h1">Mendukung proses akademik yang unggul.</h2>
                            <ol class="list-group list-group-numbered list-group-flush mt-3">
                                <li class="list-group-item px-0">Mendukung proses belajar mengajar dengan sumber informasi yang berkualitas dan relevan.</li>
                                <li class="list-group-item px-0">Mengembangkan koleksi sesuai kebutuhan kurikulum dan perkembangan ilmu pengetahuan.</li>
                                <li class="list-group-item px-0">Menyediakan layanan yang efisien, efektif, dan berbasis teknologi informasi serta komunikasi.</li>
                                <li class="list-group-item px-0">Meningkatkan literasi informasi melalui program pelatihan dan bimbingan.</li>
                                <li class="list-group-item px-0">Menjadi mitra strategis pencapaian visi dan misi Politeknik STMI Jakarta.</li>
                            </ol>
                        </article>
                    </div>
                    <div class="col-lg-6">
                        <article class="content-card h-100">
                            <p class="section-label">Fungsi</p>
                            <h2 class="section-heading h1">Menjadi simpul pengetahuan kampus.</h2>
                            <ul class="list-check mt-3 mb-0">
                                <li><strong>Edukatif:</strong> menyediakan bahan pustaka sesuai kebutuhan pemustaka.</li>
                                <li><strong>Informatif:</strong> menyediakan sumber pengetahuan yang bermutu dan terbaru.</li>
                                <li><strong>Penelitian:</strong> menyediakan sumber informasi untuk penelitian ilmiah.</li>
                                <li><strong>Administratif:</strong> mengelola koleksi dan layanan secara efektif dan efisien.</li>
                                <li><strong>Rekreatif:</strong> menyediakan bacaan bermutu untuk mengisi waktu senggang.</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
