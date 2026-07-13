@extends('layouts.public')

@section('title', 'Tata Tertib')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Ruang Bersama</p>
                <h1 class="page-title mb-0">Peraturan dan Tata Tertib</h1>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="content-card">
                            <p class="section-label">Kenyamanan Bersama</p>
                            <h2 class="section-heading h1">Mari jaga perpustakaan tetap tenang, aman, dan nyaman.</h2>
                            <p class="text-muted">Untuk ketertiban, ketenangan belajar, dan pengawasan koleksi, setiap pemustaka wajib berpakaian rapi, mengisi buku tamu, serta memperhatikan barang atau buku yang dibawa keluar.</p>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6 col-lg-4"><div class="quick-card"><span class="quick-icon mb-3"><i class="fa-solid fa-bag-shopping"></i></span><h3 class="h6">Titipkan Tas dan Jaket</h3><p class="text-muted small mb-0">Tas, jaket, dan barang sejenis tidak dibawa ke area baca atau koleksi.</p></div></div>
                                <div class="col-md-6 col-lg-4"><div class="quick-card"><span class="quick-icon mb-3"><i class="fa-solid fa-mug-hot"></i></span><h3 class="h6">Tanpa Makan dan Minum</h3><p class="text-muted small mb-0">Makanan dan minuman tidak diperbolehkan di dalam ruang perpustakaan.</p></div></div>
                                <div class="col-md-6 col-lg-4"><div class="quick-card"><span class="quick-icon mb-3"><i class="fa-solid fa-volume-xmark"></i></span><h3 class="h6">Jaga Ketenangan</h3><p class="text-muted small mb-0">Hindari berbicara keras, tertawa berlebihan, atau kegiatan yang mengganggu.</p></div></div>
                                <div class="col-md-6 col-lg-4"><div class="quick-card"><span class="quick-icon mb-3"><i class="fa-solid fa-book-open"></i></span><h3 class="h6">Rawat Koleksi</h3><p class="text-muted small mb-0">Dilarang menyobek, mencoret, atau membawa koleksi tanpa prosedur peminjaman.</p></div></div>
                                <div class="col-md-6 col-lg-4"><div class="quick-card"><span class="quick-icon mb-3"><i class="fa-solid fa-screwdriver-wrench"></i></span><h3 class="h6">Jaga Fasilitas</h3><p class="text-muted small mb-0">Gunakan meja, kursi, perangkat, dan fasilitas lain dengan penuh tanggung jawab.</p></div></div>
                                <div class="col-md-6 col-lg-4"><div class="quick-card"><span class="quick-icon mb-3"><i class="fa-solid fa-user-check"></i></span><h3 class="h6">Berpakaian Sopan</h3><p class="text-muted small mb-0">Kenakan pakaian yang rapi dan sesuai untuk lingkungan akademik.</p></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
