<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#073b74">
    <title>@yield('title', 'Dashboard') | Perpustakaan STMI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <style>
        :root {
            --navy-950: #031d3b;
            --navy-900: #052951;
            --navy-800: #073b74;
            --blue-700: #0d5ca6;
            --blue-600: #1674c8;
            --blue-500: #2e8bd8;
            --blue-100: #dcefff;
            --blue-50: #f1f8ff;
            --gold-500: #f1b84b;
            --teal-500: #2f9f98;
            --ink: #10243d;
            --muted: #607187;
            --ink-muted: var(--muted);
            --pine: var(--blue-700);
            --pine-deep: var(--navy-900);
            --clay: var(--blue-600);
            --gold: var(--gold-500);
            --canvas: #f5f8fb;
            --surface: #ffffff;
            --surface-soft: #f5f8fb;
            --line: #dfe8f1;
            --font-body: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            --sidebar-width: 264px;
            --sidebar-compact: 76px;
        }

        body {
            background-color: var(--canvas);
            background-image: radial-gradient(circle at 88% 8%, rgba(22, 116, 200, .13), transparent 22rem), linear-gradient(90deg, rgba(5, 41, 81, .025) 1px, transparent 1px);
            background-size: auto, 24px 24px;
            color: var(--ink);
            font-family: var(--font-body);
            min-width: 320px;
        }

        .app-shell { min-height: 100vh; }
        .app-sidebar {
            background-color: var(--pine-deep);
            background-image: linear-gradient(145deg, rgba(255, 255, 255, .045) 25%, transparent 25%), linear-gradient(325deg, rgba(255, 255, 255, .035) 25%, transparent 25%);
            background-position: 0 0, 16px 16px;
            background-size: 32px 32px;
            border-right: 1px solid rgba(255, 255, 255, .1);
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            position: fixed;
            transition: width .25s ease, transform .25s ease;
            width: var(--sidebar-width);
            z-index: 1040;
        }

        .brand {
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, .16);
            display: flex;
            gap: .8rem;
            min-height: 94px;
            padding: 1.1rem 1.25rem;
        }

        .brand-mark {
            align-items: center;
            background: var(--clay);
            border-radius: 50% 50% 10px 50%;
            color: #fff;
            display: flex;
            flex: 0 0 43px;
            height: 43px;
            justify-content: center;
            overflow: hidden;
            transform: rotate(-4deg);
            width: 43px;
        }

        .brand-mark img { height: 30px; object-fit: contain; transform: rotate(4deg); width: 30px; }
        .brand-copy { line-height: 1.2; min-width: 0; }
        .brand-copy strong { display: block; font-family: var(--font-body); font-size: .78rem; letter-spacing: .07em; }
        .brand-copy span { color: rgba(255, 255, 255, .67); font-size: .68rem; }
        .nav-label {
            color: rgba(255, 255, 255, .48);
            display: block;
            font-family: var(--font-body);
            font-size: .62rem;
            font-weight: 400;
            letter-spacing: .07em;
            margin: 1.8rem 1.25rem .5rem;
            text-transform: uppercase;
        }

        .side-nav { list-style: none; margin: 0; padding: 0 .9rem; }
        .side-nav a {
            align-items: center;
            border-left: 2px solid transparent;
            border-radius: 0;
            color: rgba(255, 255, 255, .82);
            display: flex;
            font-size: .86rem;
            font-weight: 700;
            gap: .85rem;
            margin: .14rem 0;
            padding: .76rem .8rem;
            text-decoration: none;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease;
            white-space: nowrap;
        }

        .side-nav a i { text-align: center; width: 1.25rem; }
        .side-nav a:hover { background: rgba(255, 255, 255, .08); color: #fff; }
        .side-nav a.active { background: rgba(255, 255, 255, .11); border-left-color: var(--gold); color: #fff; }

        .app-main {
            display: flex;
            flex-direction: column;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left .25s ease;
        }

        .topbar {
            align-items: center;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, .88);
            border-bottom: 1px solid rgba(223, 232, 241, .95);
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            min-height: 78px;
            padding: 1rem clamp(1rem, 3vw, 2.75rem);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .page-heading { font-family: var(--font-body); font-size: clamp(1.4rem, 2.3vw, 1.9rem); font-weight: 800; letter-spacing: -.035em; margin: 0; }
        .nav-toggle { border-color: var(--line); border-radius: 0; color: var(--ink); height: 38px; width: 38px; }
        .nav-toggle:hover { background: #e7f2fc; border-color: #a9c9e5; color: var(--pine); }
        .user-menu .btn { background: transparent; border-color: var(--line); border-radius: 0; color: var(--ink); font-size: .79rem; font-weight: 800; padding: .48rem .7rem; }
        .user-menu .btn:hover { background: var(--surface); border-color: var(--blue-500); }
        .dropdown-menu { background: var(--surface); border: 1px solid var(--line) !important; border-radius: 0; box-shadow: 0 18px 44px rgba(3, 29, 59, .12) !important; }

        .page-content { flex: 1; padding: clamp(1.25rem, 3.2vw, 2.8rem); }
        .card {
            background: rgba(255, 255, 255, .94);
            border: 1px solid var(--line);
            border-radius: 0;
            border-top: 3px solid var(--blue-100);
            box-shadow: none;
        }
        .card-header { background: transparent; border-bottom-color: var(--line); font-weight: 800; padding: 1rem 1.25rem; }
        .card-footer { border-top-color: var(--line) !important; }
        .table > :not(caption) > * > * { border-bottom-color: var(--line); padding: .9rem .75rem; }
        .table thead th { color: var(--ink-muted); font-family: var(--font-body); font-size: .68rem; font-weight: 800; letter-spacing: .055em; text-transform: uppercase; }
        .table-hover > tbody > tr:hover > * { background-color: rgba(220, 239, 255, .48); }
        .form-control, .form-select { background-color: var(--surface); border-color: var(--line); border-radius: 0; color: var(--ink); }
        .form-control:focus, .form-select:focus { background-color: #fff; border-color: var(--pine); box-shadow: 0 0 0 4px rgba(13, 92, 166, .1); }
        .btn { border-radius: 0; font-weight: 800; }
        .btn-primary { background-color: var(--pine); border-color: var(--pine); }
        .btn-primary:hover, .btn-primary:focus { background-color: var(--pine-deep); border-color: var(--pine-deep); }
        .btn-outline-primary { border-color: var(--pine); color: var(--pine); }
        .btn-outline-primary:hover { background-color: var(--pine); border-color: var(--pine); }
        .badge { border-radius: 0; font-size: .7rem; font-weight: 800; letter-spacing: .02em; }
        .alert { border-left: 4px solid currentColor !important; border-radius: 0; box-shadow: none !important; }
        .app-footer { color: var(--ink-muted); font-size: .75rem; padding: 1.6rem clamp(1rem, 3vw, 2.75rem); }

        .app-shell.is-collapsed .app-sidebar { width: var(--sidebar-compact); }
        .app-shell.is-collapsed .app-main { margin-left: var(--sidebar-compact); }
        .app-shell.is-collapsed .brand { justify-content: center; padding-inline: .5rem; }
        .app-shell.is-collapsed .brand-copy,
        .app-shell.is-collapsed .nav-label,
        .app-shell.is-collapsed .side-nav span { display: none; }
        .app-shell.is-collapsed .side-nav { padding-inline: .55rem; }
        .app-shell.is-collapsed .side-nav a { justify-content: center; padding-inline: .5rem; }

        @media (max-width: 991.98px) {
            .app-sidebar { transform: translateX(-105%); width: min(82vw, 290px); }
            .app-shell.nav-open .app-sidebar { transform: translateX(0); }
            .app-main, .app-shell.is-collapsed .app-main { margin-left: 0; }
            .app-shell.is-collapsed .app-sidebar { width: min(82vw, 290px); }
            .app-shell.is-collapsed .brand-copy,
            .app-shell.is-collapsed .nav-label,
            .app-shell.is-collapsed .side-nav span { display: initial; }
            .app-shell.is-collapsed .brand { justify-content: flex-start; padding-inline: 1.25rem; }
            .app-shell.is-collapsed .side-nav { padding-inline: .9rem; }
            .app-shell.is-collapsed .side-nav a { justify-content: flex-start; padding-inline: .8rem; }
            .topbar { min-height: 68px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition-duration: .01ms !important; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">
    @yield('styles')
</head>
@php
    $adminArea = match (true) {
        request()->routeIs('admin.buku.*', 'admin.klasifikasi.*') => 'Manajemen Koleksi',
        request()->routeIs('admin.anggota.*', 'admin.peminjaman.*') => 'Sirkulasi Perpustakaan',
        request()->routeIs('admin.konten.*', 'admin.permintaan.*') => 'Kelola Website',
        default => 'Ruang Kerja Petugas',
    };
    $adminName = auth()->user()?->name ?? 'Pengguna';
    $adminInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($adminName, 0, 1));
@endphp
<body class="admin-body">
    <a class="admin-skip-link" href="#admin-main-content">Lewati ke konten utama</a>
    <div class="app-shell" id="app-shell">
        <aside class="app-sidebar" id="app-sidebar" aria-label="Navigasi administrasi">
            <a class="brand text-decoration-none" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark">
                    <img src="{{ asset('images/LOGO STMI.png') }}" alt="Logo STMI" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=&quot;fa-solid fa-book-open&quot;></i>'">
                </span>
                <span class="brand-copy">
                    <strong>PERPUS STMI</strong>
                    <span>Ruang kerja administrasi</span>
                </span>
            </a>
            <button class="sidebar-close" id="sidebar-close" type="button" aria-label="Tutup navigasi">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>

            <div class="sidebar-scroll">
                <span class="nav-label">Ringkasan</span>
                <ul class="side-nav">
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard" aria-label="Dashboard" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif><i class="fa-solid fa-chart-pie" aria-hidden="true"></i><span>Dashboard</span></a></li>
                </ul>

                <span class="nav-label">Data Perpustakaan</span>
                <ul class="side-nav">
                    <li><a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}" title="Koleksi Buku" aria-label="Koleksi Buku" @if(request()->routeIs('admin.buku.*')) aria-current="page" @endif><i class="fa-solid fa-book-bookmark" aria-hidden="true"></i><span>Koleksi Buku</span></a></li>
                    <li><a href="{{ route('admin.klasifikasi.index') }}" class="{{ request()->routeIs('admin.klasifikasi.*') ? 'active' : '' }}" title="Kamus Klasifikasi" aria-label="Kamus Klasifikasi" @if(request()->routeIs('admin.klasifikasi.*')) aria-current="page" @endif><i class="fa-solid fa-tags" aria-hidden="true"></i><span>Kamus Klasifikasi</span></a></li>
                    <li><a href="{{ route('admin.anggota.index') }}" class="{{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}" title="Data Anggota" aria-label="Data Anggota" @if(request()->routeIs('admin.anggota.*')) aria-current="page" @endif><i class="fa-solid fa-users" aria-hidden="true"></i><span>Data Anggota</span></a></li>
                </ul>

                <span class="nav-label">Sirkulasi</span>
                <ul class="side-nav">
                    <li><a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" title="Peminjaman" aria-label="Peminjaman" @if(request()->routeIs('admin.peminjaman.*')) aria-current="page" @endif><i class="fa-solid fa-arrow-right-arrow-left" aria-hidden="true"></i><span>Peminjaman</span></a></li>
                </ul>

                <span class="nav-label">Kelola Website</span>
                <ul class="side-nav">
                    <li><a href="{{ route('admin.konten.index') }}" class="{{ request()->routeIs('admin.konten.*') ? 'active' : '' }}" title="Publikasi Website" aria-label="Publikasi Website" @if(request()->routeIs('admin.konten.*')) aria-current="page" @endif><i class="fa-solid fa-pen-ruler" aria-hidden="true"></i><span>Publikasi Website</span></a></li>
                    <li><a href="{{ route('admin.permintaan.index') }}" class="{{ request()->routeIs('admin.permintaan.*') ? 'active' : '' }}" title="Inbox Layanan" aria-label="Inbox Layanan" @if(request()->routeIs('admin.permintaan.*')) aria-current="page" @endif><i class="fa-solid fa-inbox" aria-hidden="true"></i><span>Inbox Layanan</span></a></li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <a class="sidebar-preview" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" title="Lihat website publik">
                    <span class="sidebar-preview__icon"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span>
                    <span class="sidebar-preview__copy"><strong>Lihat Website</strong><small>Pratinjau halaman pengunjung</small></span>
                    <i class="fa-solid fa-chevron-right sidebar-preview__arrow" aria-hidden="true"></i>
                </a>
            </div>
        </aside>

        <div class="app-main">
            <header class="topbar">
                <div class="topbar__start">
                    <button class="btn nav-toggle" id="nav-toggle" type="button" aria-label="Buka navigasi" aria-controls="app-sidebar" aria-expanded="false">
                        <i class="fa-solid fa-bars" aria-hidden="true"></i>
                    </button>
                    <div class="topbar__identity">
                        <span class="topbar__eyebrow">{{ $adminArea }}</span>
                        <h1 class="page-heading">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="topbar__actions">
                    <a class="site-preview-button" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" aria-label="Lihat website publik di tab baru">
                        <i class="fa-solid fa-globe" aria-hidden="true"></i><span>Lihat Website</span>
                    </a>
                    <div class="dropdown user-menu">
                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Buka menu akun {{ $adminName }}">
                            <span class="user-avatar">{{ $adminInitial }}</span>
                            <span class="user-menu__copy"><strong>{{ $adminName }}</strong><small>Administrator</small></span>
                            <i class="fa-solid fa-chevron-down small text-muted" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><span class="dropdown-item-text text-muted small">Sesi {{ $adminName }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit"><i class="fa-solid fa-right-from-bracket me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <main class="page-content" id="admin-main-content" tabindex="-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="app-footer">Sistem Perpustakaan Politeknik STMI Jakarta &copy; {{ now()->year }}</footer>
        </div>
    </div>
    <button class="sidebar-backdrop" id="sidebar-backdrop" type="button" aria-label="Tutup navigasi" hidden></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        (() => {
            const shell = document.getElementById('app-shell');
            const toggle = document.getElementById('nav-toggle');
            const sidebar = document.getElementById('app-sidebar');
            const closeButton = document.getElementById('sidebar-close');
            const backdrop = document.getElementById('sidebar-backdrop');
            const mainPanel = shell.querySelector('.app-main');
            const mobile = () => window.matchMedia('(max-width: 991.98px)').matches;
            let focusBeforeDrawer = null;

            const focusableElements = () => [...sidebar.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])')]
                .filter((element) => !element.hidden && element.getClientRects().length > 0);

            const syncToggle = () => {
                const expanded = mobile()
                    ? shell.classList.contains('nav-open')
                    : !shell.classList.contains('is-collapsed');
                toggle.setAttribute('aria-expanded', String(expanded));
                toggle.setAttribute('aria-label', expanded ? 'Ciutkan navigasi' : 'Buka navigasi');
            };

            const setMobileNavigation = (open, restoreFocus = true) => {
                if (!mobile()) {
                    open = false;
                }

                if (open) {
                    focusBeforeDrawer = document.activeElement;
                }

                shell.classList.toggle('nav-open', open);
                document.body.classList.toggle('navigation-open', open);
                backdrop.hidden = !open;
                sidebar.toggleAttribute('inert', mobile() && !open);
                sidebar.setAttribute('aria-hidden', String(mobile() && !open));
                mainPanel.toggleAttribute('inert', open);
                syncToggle();

                if (open) {
                    window.requestAnimationFrame(() => closeButton.focus());
                } else if (restoreFocus && focusBeforeDrawer instanceof HTMLElement) {
                    focusBeforeDrawer.focus();
                    focusBeforeDrawer = null;
                }
            };

            try {
                if (localStorage.getItem('sidebarCollapsed') === 'true' && !mobile()) {
                    shell.classList.add('is-collapsed');
                }
            } catch (error) {
                // The layout remains fully usable when storage is unavailable.
            }

            if (mobile()) {
                sidebar.setAttribute('aria-hidden', 'true');
                sidebar.setAttribute('inert', '');
            } else {
                sidebar.setAttribute('aria-hidden', 'false');
            }
            syncToggle();

            if (shell.classList.contains('is-collapsed') && mobile()) {
                shell.classList.remove('is-collapsed');
            }

            toggle.addEventListener('click', () => {
                if (mobile()) {
                    setMobileNavigation(!shell.classList.contains('nav-open'));
                    return;
                }

                shell.classList.toggle('is-collapsed');
                syncToggle();
                try {
                    localStorage.setItem('sidebarCollapsed', shell.classList.contains('is-collapsed'));
                } catch (error) {
                    // Persisting the preference is an enhancement, not a requirement.
                }
            });

            closeButton.addEventListener('click', () => setMobileNavigation(false));
            backdrop.addEventListener('click', () => setMobileNavigation(false));

            document.addEventListener('click', (event) => {
                if (mobile() && shell.classList.contains('nav-open') && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    setMobileNavigation(false);
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && shell.classList.contains('nav-open')) {
                    setMobileNavigation(false);
                    return;
                }

                if (event.key === 'Tab' && mobile() && shell.classList.contains('nav-open')) {
                    const focusable = focusableElements();
                    if (!focusable.length) return;

                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];
                    if (event.shiftKey && document.activeElement === first) {
                        event.preventDefault();
                        last.focus();
                    } else if (!event.shiftKey && document.activeElement === last) {
                        event.preventDefault();
                        first.focus();
                    }
                }
            });

            window.addEventListener('resize', () => {
                if (!mobile()) {
                    setMobileNavigation(false, false);
                    sidebar.removeAttribute('inert');
                    sidebar.setAttribute('aria-hidden', 'false');
                    mainPanel.removeAttribute('inert');
                } else if (!shell.classList.contains('nav-open')) {
                    sidebar.setAttribute('inert', '');
                    sidebar.setAttribute('aria-hidden', 'true');
                }
                syncToggle();
            });
        })();
    </script>
    <script src="{{ asset('js/interface-motion.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
