@extends('layouts.public')

@section('title', 'Struktur Organisasi')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container">
                <p class="eyebrow mb-2">Tentang Perpustakaan</p>
                <h1 class="page-title mb-0">Struktur Organisasi</h1>
            </div>
        </section>

        <section class="section-space">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 42rem;">
                    <p class="section-label">Tim Perpustakaan</p>
                    <h2 class="section-heading">Struktur pengelolaan Perpustakaan Politeknik STMI Jakarta.</h2>
                </div>
                <div class="content-card text-center p-3 p-md-5">
                    <img src="{{ asset('images/so/so.png') }}" class="img-fluid" alt="Struktur organisasi Perpustakaan Politeknik STMI Jakarta">
                </div>
            </div>
        </section>
    </main>
@endsection
