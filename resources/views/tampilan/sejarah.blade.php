@extends('layouts.public')

@section('title', 'Sejarah')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Tentang Perpustakaan</p>
                <h1 class="page-title mb-0">Sejarah Perpustakaan</h1>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="content-card">
                            <div class="row g-5 align-items-start">
                                <div class="col-md-5"><img src="{{ asset('images/stmijadul.jpg') }}" class="img-fluid rounded-4 shadow-sm w-100" alt="Perpustakaan STMI pada masa awal"></div>
                                <div class="col-md-7">
                                    <p class="section-label">Sejak 1975</p>
                                    <h2 class="section-heading h1">Menemani perjalanan pendidikan industri.</h2>
                                    <p>Perpustakaan Politeknik STMI Jakarta adalah perpustakaan perguruan tinggi di lingkungan Badan Pengembangan Sumber Daya Manusia Industri, Kementerian Perindustrian.</p>
                                    <p>Sebelumnya bernama Perpustakaan Sekolah Tinggi Manajemen Industri, perpustakaan ini didirikan pada tahun 1975 berdasarkan Surat Keputusan Menteri Perindustrian Nomor 239/M/SK/1975.</p>
                                    <p>Perubahan nama dari STMI menjadi Politeknik STMI Jakarta dilakukan berdasarkan Peraturan Menteri Perindustrian Nomor 01/M-IND/PER/1/2015.</p>
                                </div>
                            </div>
                            <hr class="my-5">
                            <div class="row g-4">
                                <div class="col-lg-7">
                                    <h3 class="h4">Tumbuh bersama sivitas akademika</h3>
                                    <p class="text-muted">Sebagai unit pelaksana teknis, perpustakaan mendukung Tri Dharma Perguruan Tinggi bagi program studi TIO, SIIO, ABO, TKP, dan TRO. Perpustakaan pernah berada di Gedung B lantai 4, kemudian lantai 2, dan kini menempati Gedung A lantai 4.</p>
                                    <p class="text-muted mb-0">Koleksi terus berkembang mencakup buku, referensi, majalah, tabloid, jurnal cetak, jurnal berlangganan, dan laporan tugas akhir.</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="soft-panel p-4 h-100">
                                        <h3 class="h5">Kepala Unit dari Masa ke Masa</h3>
                                        <ol class="mb-0 ps-3 text-muted">
                                            <li>Bapak Juhari</li>
                                            <li>Bapak Sumarno</li>
                                            <li>Bapak Leonard</li>
                                            <li>Bapak Immanuel Bangun</li>
                                            <li>Bapak Hartono</li>
                                            <li>Bapak Juhari Masudi</li>
                                            <li>Ibu Fifi Lailasari Hadianastuti</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
