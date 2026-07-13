<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#052951">
    <title>Masuk Admin | Perpustakaan STMI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono&family=DM+Serif+Display:ital@0;1&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root { --navy-950: #031d3b; --navy-900: #052951; --navy-800: #073b74; --blue-700: #0d5ca6; --blue-600: #1674c8; --blue-100: #dcefff; --ink: #10243d; --muted: #607187; --gold: #f1b84b; --canvas: #f5f8fb; --paper: #ffffff; --line: #dfe8f1; }
        body { background-color: var(--canvas); background-image: radial-gradient(circle at 86% 10%, rgba(22, 116, 200, .16), transparent 20rem), linear-gradient(90deg, rgba(5, 41, 81, .025) 1px, transparent 1px); background-size: auto, 24px 24px; color: var(--ink); font-family: 'Manrope', sans-serif; min-height: 100vh; }
        .login-page { min-height: 100vh; padding: clamp(1rem, 3vw, 2.5rem); }
        .brand-panel { background: radial-gradient(circle at 18% 18%, rgba(46, 139, 216, .22), transparent 16rem), linear-gradient(160deg, var(--navy-800) 0%, var(--navy-900) 52%, var(--navy-950) 100%); background-image: radial-gradient(circle at 18% 18%, rgba(46, 139, 216, .22), transparent 16rem), linear-gradient(160deg, var(--navy-800) 0%, var(--navy-900) 52%, var(--navy-950) 100%), linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px), linear-gradient(0deg, rgba(255, 255, 255, .06) 1px, transparent 1px); background-size: auto, auto, 24px 24px, 24px 24px; border-bottom: 5px solid var(--blue-600); color: white; min-height: 560px; overflow: hidden; padding: clamp(2rem, 5vw, 4rem); position: relative; }
        .brand-panel::after { border: 1px solid rgba(255,255,255,.2); border-radius: 48% 52% 42% 58%; content: ''; height: 27rem; position: absolute; right: -9rem; top: -10rem; width: 27rem; }
        .brand-panel h1 { font-family: 'DM Serif Display', serif; font-size: clamp(2.7rem, 4.6vw, 4.3rem); font-weight: 400; letter-spacing: -.035em; line-height: .94; position: relative; z-index: 1; }
        .brand-panel p, .brand-panel .brand-note { position: relative; z-index: 1; }
        .login-card { background: var(--paper); border: 1px solid var(--line); border-radius: 0; border-top: 4px solid var(--blue-600); box-shadow: 12px 12px 0 rgba(5, 41, 81, .07); max-width: 480px; }
        .login-card h2 { font-family: 'DM Serif Display', serif; font-weight: 400 !important; letter-spacing: -.02em; }
        .form-label { font-size: .8rem; font-weight: 800 !important; }
        .form-control { background: #fff; border-color: var(--line); border-radius: 0; padding: .82rem .9rem; }
        .form-control:focus { border-color: var(--blue-700); box-shadow: 0 0 0 .24rem rgba(22, 116, 200, .14); }
        .form-check-input { border-radius: 0; }
        .form-check-input:checked { background-color: var(--blue-700); border-color: var(--blue-700); }
        .btn-login { background: var(--blue-700); border-color: var(--blue-700); border-radius: 0; color: white; font-size: .76rem; font-weight: 800; letter-spacing: .045em; padding: .85rem 1rem; text-transform: uppercase; }
        .btn-login:hover { background: var(--navy-900); border-color: var(--navy-900); color: white; }
        .text-muted { color: var(--muted) !important; }
        a { color: var(--blue-700); }
        .login-card .alert { border-left: 4px solid currentColor; border-radius: 0; }
    </style>
</head>
<body>
    <main class="login-page container-fluid d-flex align-items-center">
        <div class="row g-4 align-items-stretch w-100 mx-auto" style="max-width: 1120px;">
            <div class="col-lg-6 d-none d-lg-block">
                <section class="brand-panel d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 text-uppercase fw-bold small mb-5" style="letter-spacing: .12em;"><i class="fa-solid fa-book-open"></i> Perpustakaan STMI</div>
                        <h1>Pengetahuan yang terkelola, layanan yang terpercaya.</h1>
                        <p class="mt-4 mb-0 opacity-75">Masuk ke ruang administrasi untuk mengelola koleksi, anggota, dan sirkulasi perpustakaan.</p>
                    </div>
                    <div class="brand-note small opacity-75"><i class="fa-solid fa-shield-halved me-2"></i>Akses khusus administrator</div>
                </section>
            </div>
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <section class="card login-card w-100">
                    <div class="card-body p-4 p-sm-5">
                        <a href="{{ route('home') }}" class="text-decoration-none small text-muted"><i class="fa-solid fa-arrow-left me-2"></i>Kembali ke situs</a>
                        <div class="mt-4 mb-4">
                            <h2 class="h3 fw-bold mb-2">Masuk Admin</h2>
                            <p class="text-muted mb-0">Gunakan ID atau email administrator dan kata sandi Anda.</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger border-0"><i class="fa-solid fa-circle-exclamation me-2"></i>{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="login" class="form-label fw-semibold">ID atau Email Administrator</label>
                                <input id="login" name="login" type="text" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}" required autofocus autocomplete="username">
                                @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember" @checked(old('remember'))>
                                <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                            </div>
                            <button type="submit" class="btn btn-login w-100"><i class="fa-solid fa-right-to-bracket me-2"></i>Masuk ke Dashboard</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
