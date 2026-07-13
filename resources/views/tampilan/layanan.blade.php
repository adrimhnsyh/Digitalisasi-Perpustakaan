@extends('layouts.public')

@section('title', 'Layanan Perpustakaan')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Untuk Pemustaka</p>
                <h1 class="page-title mb-0">Layanan Perpustakaan</h1>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="content-card">
                            <p class="section-label">Layanan Akademik</p>
                            <h2 class="section-heading h1">Dukungan untuk belajar, riset, dan penyelesaian studi.</h2>
                            <p class="text-muted">Perpustakaan Politeknik STMI Jakarta menyediakan layanan sirkulasi, referensi, penelusuran informasi, cek plagiarisme, dan surat bebas perpustakaan bagi mahasiswa, dosen, serta karyawan.</p>

                            <div class="accordion mt-4" id="library-services">
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="service-circulation-heading">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#service-circulation" aria-expanded="true" aria-controls="service-circulation">Layanan Sirkulasi</button>
                                    </h3>
                                    <div id="service-circulation" class="accordion-collapse collapse show" aria-labelledby="service-circulation-heading">
                                        <div class="accordion-body p-4">
                                            <p>Sirkulasi mencakup peminjaman, pengembalian, dan perpanjangan koleksi buku teks atau buku umum. Petugas membantu pemustaka memanfaatkan koleksi secara tertib.</p>
                                            <div class="row g-4">
                                                <div class="col-md-4">
                                                    <h4 class="h6">Peminjaman</h4>
                                                    <ol class="small mb-0">
                                                        <li>Isi buku tamu dan cari koleksi.</li>
                                                        <li>Bawa koleksi serta kartu identitas ke meja sirkulasi.</li>
                                                        <li>Petugas memproses transaksi pada sistem.</li>
                                                        <li>Maksimal {{ config('library.loan_max_items') }} judul dengan masa pinjam {{ config('library.loan_duration_days') }} hari.</li>
                                                    </ol>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4 class="h6">Pengembalian</h4>
                                                    <ol class="small mb-0">
                                                        <li>Serahkan koleksi dan kartu identitas ke meja sirkulasi.</li>
                                                        <li>Petugas memproses pengembalian pada sistem.</li>
                                                        <li>Keterlambatan akan diinformasikan sesuai ketentuan yang berlaku.</li>
                                                    </ol>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4 class="h6">Perpanjangan</h4>
                                                    <ul class="small mb-0">
                                                        <li>Koleksi tidak sedang dibutuhkan pemustaka lain.</li>
                                                        <li>Koleksi dibawa ke meja sirkulasi.</li>
                                                        <li>Perpanjangan dilakukan satu kali sesuai ketentuan.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="service-reference-heading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#service-reference" aria-expanded="false" aria-controls="service-reference">Layanan Referensi dan Penelusuran</button>
                                    </h3>
                                    <div id="service-reference" class="accordion-collapse collapse" aria-labelledby="service-reference-heading">
                                        <div class="accordion-body p-4">
                                            <p>Layanan referensi menyediakan kamus, ensiklopedia, handbook, direktori, peraturan, prosiding, laporan penelitian, skripsi, dan sumber informasi lain. Koleksi referensi digunakan di ruang perpustakaan dan tidak dipinjamkan untuk dibawa pulang.</p>
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <h4 class="h6">Bantuan yang Tersedia</h4>
                                                    <ul class="list-check mb-0 small">
                                                        <li>Pencarian koleksi melalui katalog dan sumber digital.</li>
                                                        <li>Bimbingan penggunaan koleksi referensi.</li>
                                                        <li>Penelusuran artikel, jurnal, tugas akhir, dan sumber riset.</li>
                                                        <li>Penggunaan database dan platform akademik.</li>
                                                        <li>Cek plagiarisme melalui Turnitin sesuai prosedur institusi.</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4 class="h6">Koleksi Referensi</h4>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm mb-0">
                                                            <thead><tr><th>Jenis</th><th>Judul</th><th>Eksemplar</th></tr></thead>
                                                            <tbody>
                                                                <tr><td>Kamus</td><td>25</td><td>46</td></tr>
                                                                <tr><td>Ensiklopedia</td><td>2</td><td>2</td></tr>
                                                                <tr><td>Handbook dan manual</td><td>40</td><td>60</td></tr>
                                                                <tr><td>Laporan penelitian</td><td>60</td><td>60</td></tr>
                                                                <tr><td>Tugas akhir</td><td>3.195</td><td>3.195</td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="service-clearance-heading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#service-clearance" aria-expanded="false" aria-controls="service-clearance">Surat Bebas Perpustakaan</button>
                                    </h3>
                                    <div id="service-clearance" class="accordion-collapse collapse" aria-labelledby="service-clearance-heading">
                                        <div class="accordion-body p-4">
                                            <p>Surat Bebas Perpustakaan merupakan proses administrasi bagi mahasiswa sebelum dinyatakan lulus. Proses ini memastikan kewajiban pengembalian koleksi, unggah tugas akhir, dan persyaratan akademik lain telah dipenuhi.</p>
                                            <ol class="mb-0">
                                                <li>Selesaikan revisi laporan tugas akhir dan seluruh persetujuan akademik.</li>
                                                <li>Unggah laporan ke repositori melalui tautan yang diberikan perpustakaan.</li>
                                                <li>Serahkan hardcopy laporan tugas akhir sesuai ketentuan.</li>
                                                <li>Siapkan hasil Turnitin dengan tingkat kesamaan di bawah 30 persen.</li>
                                                <li>Tunjukkan tautan repositori yang telah dikonfirmasi petugas.</li>
                                                <li>Ajukan permohonan melalui e-learning, lalu tunggu validasi pustakawan.</li>
                                            </ol>
                                        </div>
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
