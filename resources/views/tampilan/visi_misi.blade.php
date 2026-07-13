@extends('layouts.public')

@section('title', 'Visi dan Misi')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Tentang Perpustakaan</p>
                <h1 class="page-title mb-0">Visi dan Misi</h1>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="content-card h-100" style="background: linear-gradient(145deg, #e4f1ed, #fff);">
                            <p class="section-label">Visi</p>
                            <h2 class="section-heading">Pusat informasi yang inovatif dan berbasis teknologi.</h2>
                            <p class="text-muted mb-0">Terwujudnya perpustakaan sebagai pusat layanan informasi dan referensi yang inovatif, berbasis teknologi informasi sebagai pendukung utama tercapainya Tridharma Perguruan Tinggi.</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="content-card h-100">
                            <p class="section-label">Misi</p>
                            <h2 class="section-heading h1">Melayani kebutuhan pengetahuan dengan lebih baik.</h2>
                            <ol class="list-group list-group-numbered list-group-flush mt-3">
                                <li class="list-group-item px-0">Menyediakan koleksi yang lengkap dan berkualitas untuk pembelajaran, pengajaran, dan riset ilmiah.</li>
                                <li class="list-group-item px-0">Memberikan layanan informasi yang prima dan responsif terhadap kebutuhan sivitas akademika.</li>
                                <li class="list-group-item px-0">Mengembangkan sistem perpustakaan berbasis teknologi informasi untuk meningkatkan efisiensi layanan.</li>
                                <li class="list-group-item px-0">Meningkatkan pemanfaatan perpustakaan melalui program literasi informasi.</li>
                                <li class="list-group-item px-0">Meningkatkan kompetensi SDM perpustakaan melalui pelatihan berkelanjutan.</li>
                                <li class="list-group-item px-0">Menjalin kerja sama dengan institusi lain untuk memperluas jaringan informasi.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
