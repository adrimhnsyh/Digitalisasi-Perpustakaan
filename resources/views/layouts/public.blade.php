<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Perpustakaan Politeknik STMI Jakarta')">
    <meta name="theme-color" content="#073b74">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Perpustakaan Politeknik STMI Jakarta">
    <meta property="og:title" content="@yield('title', 'Perpustakaan') | Politeknik STMI Jakarta">
    <meta property="og:description" content="@yield('description', 'Perpustakaan Politeknik STMI Jakarta')">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', 'Perpustakaan') | Politeknik STMI Jakarta</title>

    <link rel="icon" type="image/png" href="{{ asset('images/LOGO STMI.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/public-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public-features.css') }}">
    @yield('styles')
</head>
<body class="{{ request()->routeIs('home') ? 'public-home' : 'public-inner' }}">
    <a class="skip-link" href="#main-content">Lewati ke konten utama</a>

    <header class="utility-bar">
        <div class="container">
            <div class="utility-bar__inner">
                <a href="mailto:perpustakaan@stmi.ac.id" class="utility-bar__item">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <span>perpustakaan@stmi.ac.id</span>
                </a>
                <div class="utility-bar__right">
                    <span class="utility-bar__item utility-status {{ $libraryStatus['is_open'] ? 'is-open' : 'is-closed' }}">
                        <span class="utility-status__indicator" aria-hidden="true"></span>
                        <span class="utility-status__copy">
                            <strong>{{ $libraryStatus['label'] }}</strong>
                            <span class="utility-status__separator" aria-hidden="true">&middot;</span>
                            <span class="utility-status__detail">{{ $libraryStatus['detail'] }}</span>
                        </span>
                    </span>
                    <a href="https://instagram.com/perpus.politeknikstmijkt" target="_blank" rel="noopener noreferrer" class="utility-bar__social" aria-label="Instagram Perpustakaan STMI">
                        <i class="bi bi-instagram" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg public-navbar" aria-label="Navigasi utama">
        <div class="container">
            <a class="public-brand" href="{{ route('home') }}" aria-label="Perpustakaan Politeknik STMI Jakarta - Beranda">
                <span class="public-brand__mark">
                    <img src="{{ asset('images/LOGO STMI.png') }}" alt="" width="50" height="50">
                </span>
                <span class="public-brand__copy">
                    <strong>Perpustakaan</strong>
                    <small>Politeknik STMI Jakarta</small>
                </span>
            </a>

            <button class="navbar-toggler public-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#public-navigation" aria-controls="public-navigation" aria-expanded="false" aria-label="Buka navigasi">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>

            <div class="collapse navbar-collapse" id="public-navigation">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Katalog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('tampilan.sejarah', 'tampilan.visi-misi', 'tampilan.tujuan-fungsi', 'tampilan.struktur-organisasi', 'tampilan.peraturan-tata-tertib') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tentang</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('tampilan.sejarah') }}">Sejarah</a></li>
                            <li><a class="dropdown-item" href="{{ route('tampilan.visi-misi') }}">Visi dan Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('tampilan.tujuan-fungsi') }}">Tujuan dan Fungsi</a></li>
                            <li><a class="dropdown-item" href="{{ route('tampilan.struktur-organisasi') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('tampilan.peraturan-tata-tertib') }}">Tata Tertib</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tampilan.layanan') ? 'active' : '' }}" href="{{ route('tampilan.layanan') }}">Layanan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('explore.*', 'e-resources', 'public-content.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Jelajahi</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('explore.index') }}">Pusat Eksplorasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('e-resources') }}">E-Resources</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown nav-service-item">
                        <a class="nav-service-link dropdown-toggle {{ request()->routeIs('loan-status.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-check" aria-hidden="true"></i><span>Layanan Saya</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end nav-service-menu">
                            <li><a class="dropdown-item" href="{{ route('loan-status.index') }}"><i class="bi bi-journal-check"></i><span><strong>Cek Peminjaman</strong><small>Lihat tenggat dan riwayat</small></span></a></li>
                            <li><a class="dropdown-item" href="{{ route('explore.index', ['type' => 'usulan_buku']) }}#hubungi"><i class="bi bi-bookmark-plus"></i><span><strong>Usulkan Buku</strong><small>Kirim kebutuhan koleksi</small></span></a></li>
                            <li><a class="dropdown-item" href="{{ route('explore.index', ['type' => 'tanya_pustakawan']) }}#hubungi"><i class="bi bi-chat-dots"></i><span><strong>Tanya Pustakawan</strong><small>Minta bantuan referensi</small></span></a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-admin-item">
                        @auth
                            <a class="nav-admin-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i> Dashboard</a>
                        @else
                            <a class="nav-admin-link" href="{{ route('login') }}"><i class="bi bi-shield-lock" aria-hidden="true"></i> Masuk Admin</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="main-content">
        @yield('content')
    </div>

    <footer class="public-footer">
        <div class="public-footer__glow" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5">
                    <a class="footer-brand" href="{{ route('home') }}">
                        <span class="footer-brand__mark"><img src="{{ asset('images/LOGO STMI.png') }}" alt="" width="52" height="52"></span>
                        <span><strong>Perpustakaan</strong><small>Politeknik STMI Jakarta</small></span>
                    </a>
                    <p class="public-footer__summary">Ruang belajar dan pusat informasi untuk mendukung pendidikan, penelitian, dan karya sivitas akademika.</p>
                    <div class="footer-socials">
                        <a href="mailto:perpustakaan@stmi.ac.id" aria-label="Kirim email"><i class="bi bi-envelope" aria-hidden="true"></i></a>
                        <a href="https://instagram.com/perpus.politeknikstmijkt" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1">
                    <h2 class="footer-title">Jelajahi</h2>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}">Katalog</a></li>
                        <li><a href="{{ route('tampilan.layanan') }}">Layanan</a></li>
                        <li><a href="{{ route('explore.index') }}">Eksplorasi</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h2 class="footer-title">Informasi</h2>
                    <ul class="footer-links">
                        <li><a href="{{ route('tampilan.visi-misi') }}">Visi dan Misi</a></li>
                        <li><a href="{{ route('tampilan.struktur-organisasi') }}">Struktur</a></li>
                        <li><a href="{{ route('tampilan.peraturan-tata-tertib') }}">Tata Tertib</a></li>
                        <li><a href="{{ route('loan-status.index') }}">Cek Peminjaman</a></li>
                        <li><a href="{{ route('login') }}">Admin</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-hours {{ $libraryStatus['is_open'] ? 'is-open' : 'is-closed' }}">
                        <span class="footer-hours__icon"><i class="bi {{ $libraryStatus['is_open'] ? 'bi-unlock' : 'bi-clock' }}" aria-hidden="true"></i></span>
                        <p>Status layanan</p>
                        <strong>{{ $libraryStatus['label'] }}</strong>
                        <small>{{ $libraryStatus['detail'] }}</small>
                    </div>
                </div>
            </div>

            <div class="public-footer__bottom">
                <p>&copy; {{ now()->year }} Perpustakaan Politeknik STMI Jakarta</p>
                <p>Dibangun untuk akses pengetahuan yang lebih dekat.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/interface-motion.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
