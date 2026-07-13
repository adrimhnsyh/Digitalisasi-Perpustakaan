@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <style>
        .dashboard-intro {
            background: linear-gradient(135deg, #073b74, #052951 58%, #031d3b);
            color: #fff;
            min-height: 275px;
            overflow: hidden;
            padding: clamp(1.6rem, 4vw, 3.2rem);
            position: relative;
        }
        .dashboard-intro::before { border: 1px solid rgba(255, 255, 255, .24); border-radius: 48% 52% 42% 58%; content: ''; height: 31rem; position: absolute; right: -10rem; top: -16rem; width: 31rem; }
        .dashboard-intro::after { background-image: linear-gradient(90deg, rgba(255, 255, 255, .09) 1px, transparent 1px), linear-gradient(0deg, rgba(255, 255, 255, .09) 1px, transparent 1px); background-size: 18px 18px; bottom: -3.5rem; content: ''; height: 14rem; position: absolute; right: 4%; transform: rotate(8deg); width: 14rem; }
        .dashboard-intro > .row { position: relative; z-index: 1; }
        .dashboard-kicker { color: #f0c780; font-family: 'DM Mono', monospace; font-size: .66rem; letter-spacing: .08em; text-transform: uppercase; }
        .dashboard-intro h2 { font-family: 'DM Serif Display', serif; font-size: clamp(2.35rem, 4.4vw, 4rem); font-weight: 400; letter-spacing: -.035em; line-height: .94; max-width: 13ch; }
        .dashboard-intro-copy { color: rgba(255, 255, 255, .74); max-width: 34rem; }
        .dashboard-action { background: #fff; border: 0; color: #073b74; font-size: .76rem; letter-spacing: .04em; padding: .76rem 1rem; text-transform: uppercase; }
        .dashboard-action:hover { background: #f0c780; color: #052951; }
        .availability-figure { border-left: 1px solid rgba(255, 255, 255, .3); padding-left: clamp(1.4rem, 3vw, 2.4rem); }
        .availability-label { color: rgba(255, 255, 255, .7); display: block; font-family: 'DM Mono', monospace; font-size: .65rem; letter-spacing: .07em; text-transform: uppercase; }
        .availability-figure strong { display: block; font-family: 'DM Serif Display', serif; font-size: clamp(4.4rem, 8vw, 6.5rem); font-weight: 400; letter-spacing: -.08em; line-height: .84; margin: .8rem 0 .5rem; }
        .availability-figure strong small { color: #f0c780; font-family: 'Manrope', sans-serif; font-size: .25em; letter-spacing: 0; }
        .availability-track { background: rgba(255, 255, 255, .22); height: 5px; margin: 1.3rem 0 .8rem; overflow: hidden; }
        .availability-track span { background: #f0c780; display: block; height: 100%; }
        .availability-caption { color: rgba(255, 255, 255, .72); font-size: .78rem; }
        .dashboard-sheet, .attention-sheet, .catalog-sheet, .activity-sheet { background: rgba(255, 255, 255, .94); border: 1px solid var(--line); }
        .dashboard-sheet { border-top: 4px solid #1674c8; }
        .dashboard-sheet-header { align-items: end; border-bottom: 1px solid var(--line); display: flex; gap: 1rem; justify-content: space-between; padding: 1.3rem 1.4rem 1rem; }
        .dashboard-sheet-header h3, .catalog-sheet h3, .activity-sheet h3, .attention-sheet h3 { font-family: 'DM Serif Display', serif; font-size: 1.55rem; font-weight: 400; letter-spacing: -.02em; margin: 0; }
        .sheet-label { color: var(--ink-muted); font-family: 'DM Mono', monospace; font-size: .62rem; letter-spacing: .07em; text-transform: uppercase; }
        .metric-row { align-items: center; border-bottom: 1px solid var(--line); display: grid; gap: 1rem; grid-template-columns: minmax(8rem, 1.15fr) minmax(6rem, .65fr) minmax(9rem, 1.55fr); padding: 1.25rem 1.4rem; }
        .metric-row:last-child { border-bottom: 0; }
        .metric-name { font-size: .83rem; font-weight: 800; margin: 0; }
        .metric-note { color: var(--ink-muted); font-size: .73rem; margin: .18rem 0 0; }
        .metric-value { color: var(--pine-deep); font-family: 'DM Serif Display', serif; font-size: 2.3rem; letter-spacing: -.05em; line-height: 1; text-align: right; }
        .metric-bar { background: #dce9f5; height: 7px; overflow: hidden; position: relative; }
        .metric-bar span { background: #2e8bd8; display: block; height: 100%; min-width: 4px; }
        .metric-bar.pine span { background: var(--pine); }
        .metric-bar.gold span { background: var(--gold); }
        .metric-meta { color: var(--ink-muted); font-size: .72rem; margin-top: .38rem; text-align: right; }
        .attention-sheet { background: #eaf4fd; border-top: 4px solid var(--pine); height: 100%; padding: 1.45rem; position: relative; }
        .attention-sheet::after { border: 1px solid rgba(13, 92, 166, .18); border-radius: 50%; bottom: -4rem; content: ''; height: 11rem; position: absolute; right: -3rem; width: 11rem; }
        .attention-sheet > * { position: relative; z-index: 1; }
        .attention-count { color: var(--pine-deep); font-family: 'DM Serif Display', serif; font-size: 5rem; letter-spacing: -.08em; line-height: .9; margin: 1.15rem 0 .5rem; }
        .attention-status { align-items: center; color: var(--ink-muted); display: flex; font-size: .79rem; gap: .55rem; }
        .attention-status i { color: {{ $peminjamanTerlambat > 0 ? '#c75d46' : '#0d5ca6' }}; }
        .attention-link { align-items: center; border-top: 1px solid rgba(13, 92, 166, .22); display: flex; font-size: .78rem; font-weight: 800; justify-content: space-between; margin-top: 2rem; padding-top: .9rem; text-decoration: none; }
        .catalog-sheet { border-top: 4px solid #2e8bd8; padding: 1.4rem; }
        .catalog-sheet h3 { margin-bottom: .2rem; }
        .catalog-bar { margin-top: 1.25rem; }
        .catalog-bar:first-of-type { margin-top: 1.6rem; }
        .catalog-bar-top { align-items: center; display: flex; font-size: .8rem; justify-content: space-between; margin-bottom: .45rem; }
        .catalog-bar-top strong { font-family: 'DM Serif Display', serif; font-size: 1.35rem; font-weight: 400; }
        .catalog-track { background: #dce9f5; height: 6px; overflow: hidden; }
        .catalog-track span { background: #2e8bd8; display: block; height: 100%; min-width: 3px; }
        .catalog-bar:nth-of-type(3) .catalog-track span { background: var(--pine); }
        .catalog-bar:nth-of-type(4) .catalog-track span { background: var(--gold); }
        .catalog-link { display: inline-flex; font-size: .78rem; font-weight: 800; margin-top: 1.8rem; text-decoration: none; }
        .activity-sheet { border-top: 4px solid var(--pine); overflow: hidden; }
        .activity-sheet-header { align-items: center; border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; padding: 1.3rem 1.4rem 1rem; }
        .activity-sheet-header a { font-family: 'DM Mono', monospace; font-size: .65rem; letter-spacing: .04em; text-decoration: none; text-transform: uppercase; }
        .activity-table { margin: 0; }
        .activity-table > :not(caption) > * > * { padding-block: 1rem; }
        .activity-table tbody td:first-child { border-left: 3px solid transparent; }
        .activity-table tbody tr:hover td:first-child { border-left-color: #1674c8; }
        .activity-name { color: var(--ink); font-weight: 800; text-decoration: none; }
        .activity-collection { color: var(--ink-muted); font-size: .78rem; }
        .status-pill { border: 1px solid currentColor; display: inline-block; font-family: 'DM Mono', monospace; font-size: .6rem; letter-spacing: .035em; padding: .27rem .38rem; text-transform: uppercase; }
        .status-pill.is-returned { color: var(--pine); }
        .status-pill.is-active { color: #a26517; }
        .status-pill.is-late { color: var(--clay); }
        .ops-card { align-items: center; background: rgba(255, 253, 248, .92); border: 1px solid var(--line); color: var(--ink); display: flex; gap: 1rem; min-height: 104px; padding: 1.05rem 1.15rem; text-decoration: none; transition: border-color .2s ease, transform .2s ease; }
        .ops-card:hover { border-color: #1674c8; color: var(--ink); transform: translateY(-2px); }
        .ops-icon { align-items: center; background: #e7f2fc; color: #0d5ca6; display: inline-flex; flex: 0 0 44px; height: 44px; justify-content: center; }
        .ops-card:nth-child(2) .ops-icon { background: #dcefff; color: #073b74; }
        .ops-card:nth-child(3) .ops-icon { background: #edf6ff; color: #1674c8; }
        .ops-copy { flex: 1; min-width: 0; }
        .ops-copy strong { display: block; font-family: 'DM Serif Display', serif; font-size: 1.7rem; font-weight: 400; line-height: 1; }
        .ops-copy span { color: var(--ink-muted); display: block; font-size: .72rem; margin-top: .3rem; }
        .ops-arrow { color: var(--ink-muted); font-size: .75rem; }

        @media (max-width: 767.98px) {
            .availability-figure { border-left: 0; border-top: 1px solid rgba(255, 255, 255, .3); margin-top: 1.5rem; padding: 1.4rem 0 0; }
            .metric-row { grid-template-columns: 1fr auto; }
            .metric-row > :last-child { grid-column: 1 / -1; }
            .metric-bar, .metric-meta { text-align: left; }
            .activity-table thead { display: none; }
            .activity-table, .activity-table tbody, .activity-table tr, .activity-table td { display: block; width: 100%; }
            .activity-table tr { border-bottom: 1px solid var(--line); padding: .7rem 1.2rem; }
            .activity-table > tbody > tr > td { border: 0; padding: .25rem 0; }
            .activity-table > tbody > tr > td:first-child { border-left: 0; }
        }
    </style>
@endsection

@section('content')
    @php
        $availabilityRate = $totalEksemplar > 0 ? (int) round(($totalTersedia / $totalEksemplar) * 100) : 0;
        $currentlyBorrowed = max($totalEksemplar - $totalTersedia, 0);
        $catalogTotal = max($totalBuku + $totalJurnal + $totalTugasAkhir, 1);
    @endphp

    <section class="dashboard-intro mb-4">
        <div class="row align-items-end g-4">
            <div class="col-lg-7">
                <p class="dashboard-kicker mb-3">Ruang kerja perpustakaan / {{ now()->translatedFormat('d M Y') }}</p>
                <h2 class="mb-3">Selamat datang, {{ auth()->user()?->name }}.</h2>
                <p class="dashboard-intro-copy mb-4">Pantau koleksi, pergerakan peminjaman, dan hal yang perlu ditindaklanjuti tanpa harus menelusuri banyak halaman.</p>
                <a href="{{ route('admin.peminjaman.create') }}" class="btn dashboard-action"><i class="fa-solid fa-plus me-2"></i>Catat Peminjaman</a>
            </div>
            <div class="col-lg-5">
                <div class="availability-figure">
                    <span class="availability-label">Kesiapan sirkulasi</span>
                    <strong>{{ $availabilityRate }}<small>% tersedia</small></strong>
                    <div class="availability-track" aria-label="{{ $availabilityRate }} persen koleksi tersedia"><span style="width: {{ $availabilityRate }}%"></span></div>
                    <span class="availability-caption">{{ number_format($totalTersedia) }} dari {{ number_format($totalEksemplar) }} eksemplar siap dipinjam.</span>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a class="ops-card h-100" href="{{ route('admin.permintaan.index', ['status' => 'baru']) }}">
                <span class="ops-icon"><i class="fa-regular fa-message"></i></span>
                <span class="ops-copy"><strong>{{ number_format($permintaanBaru) }}</strong><span>permintaan publik menunggu respons</span></span>
                <i class="fa-solid fa-arrow-right ops-arrow"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a class="ops-card h-100" href="{{ route('admin.konten.index', ['status' => 'draft']) }}">
                <span class="ops-icon"><i class="fa-regular fa-pen-to-square"></i></span>
                <span class="ops-copy"><strong>{{ number_format($kontenDraft) }}</strong><span>konten publik masih berupa draft</span></span>
                <i class="fa-solid fa-arrow-right ops-arrow"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a class="ops-card h-100" href="{{ route('admin.buku.index') }}">
                <span class="ops-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                <span class="ops-copy"><strong>{{ number_format($koleksiBelumDiklasifikasi) }}</strong><span>koleksi lama siap dianalisis dari abstrak</span></span>
                <i class="fa-solid fa-arrow-right ops-arrow"></i>
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <section class="dashboard-sheet h-100">
                <div class="dashboard-sheet-header">
                    <div>
                        <span class="sheet-label">Snapshot koleksi</span>
                        <h3>Nadi perpustakaan</h3>
                    </div>
                    <i class="fa-solid fa-wave-square fs-4" style="color: #1674c8"></i>
                </div>
                <div class="metric-row">
                    <div>
                        <p class="metric-name">Eksemplar terdaftar</p>
                        <p class="metric-note">Seluruh unit fisik dalam koleksi</p>
                    </div>
                    <div>
                        <div class="metric-value">{{ number_format($totalEksemplar) }}</div>
                        <p class="metric-meta">unit</p>
                    </div>
                    <div>
                        <div class="metric-bar gold"><span style="width: 100%"></span></div>
                        <p class="metric-meta">Basis perhitungan koleksi</p>
                    </div>
                </div>
                <div class="metric-row">
                    <div>
                        <p class="metric-name">Siap dipinjam</p>
                        <p class="metric-note">Koleksi yang tersedia untuk pemustaka</p>
                    </div>
                    <div>
                        <div class="metric-value">{{ number_format($totalTersedia) }}</div>
                        <p class="metric-meta">{{ $availabilityRate }}% dari total</p>
                    </div>
                    <div>
                        <div class="metric-bar pine"><span style="width: {{ $availabilityRate }}%"></span></div>
                        <p class="metric-meta">Ketersediaan saat ini</p>
                    </div>
                </div>
                <div class="metric-row">
                    <div>
                        <p class="metric-name">Item dalam sirkulasi</p>
                        <p class="metric-note">Peminjaman aktif yang belum selesai</p>
                    </div>
                    <div>
                        <div class="metric-value">{{ number_format($peminjamanAktif) }}</div>
                        <p class="metric-meta">{{ number_format($currentlyBorrowed) }} item tercatat</p>
                    </div>
                    <div>
                        <div class="metric-bar"><span style="width: {{ $totalEksemplar > 0 ? min(100, (int) round(($currentlyBorrowed / $totalEksemplar) * 100)) : 0 }}%"></span></div>
                        <p class="metric-meta">Pergerakan peminjaman</p>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-4">
            <aside class="attention-sheet">
                <span class="sheet-label">Perlu diperhatikan</span>
                <h3 class="mt-1">Tenggat pengembalian</h3>
                <div class="attention-count">{{ number_format($peminjamanTerlambat) }}</div>
                <p class="attention-status mb-0">
                    <i class="fa-solid {{ $peminjamanTerlambat > 0 ? 'fa-triangle-exclamation' : 'fa-circle-check' }}"></i>
                    {{ $peminjamanTerlambat > 0 ? 'Transaksi melewati tanggal kembali.' : 'Tidak ada transaksi yang terlambat.' }}
                </p>
                <a class="attention-link" href="{{ route('admin.peminjaman.index') }}">
                    <span>Tinjau sirkulasi</span><i class="fa-solid fa-arrow-right"></i>
                </a>
            </aside>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <section class="catalog-sheet h-100">
                <span class="sheet-label">Komposisi katalog</span>
                <h3>Ragam bahan baca</h3>
                <div class="catalog-bar">
                    <div class="catalog-bar-top"><span>Buku</span><strong>{{ number_format($totalBuku) }}</strong></div>
                    <div class="catalog-track"><span style="width: {{ (int) round(($totalBuku / $catalogTotal) * 100) }}%"></span></div>
                </div>
                <div class="catalog-bar">
                    <div class="catalog-bar-top"><span>Jurnal</span><strong>{{ number_format($totalJurnal) }}</strong></div>
                    <div class="catalog-track"><span style="width: {{ (int) round(($totalJurnal / $catalogTotal) * 100) }}%"></span></div>
                </div>
                <div class="catalog-bar">
                    <div class="catalog-bar-top"><span>Tugas Akhir</span><strong>{{ number_format($totalTugasAkhir) }}</strong></div>
                    <div class="catalog-track"><span style="width: {{ (int) round(($totalTugasAkhir / $catalogTotal) * 100) }}%"></span></div>
                </div>
                <a class="catalog-link" href="{{ route('admin.buku.index') }}">Kelola semua koleksi <i class="fa-solid fa-arrow-right ms-2"></i></a>
            </section>
        </div>
        <div class="col-lg-8">
            <section class="activity-sheet h-100">
                <div class="activity-sheet-header">
                    <div>
                        <span class="sheet-label">Sirkulasi terakhir</span>
                        <h3>Aktivitas peminjaman</h3>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table activity-table align-middle">
                        <thead>
                            <tr><th class="ps-4">Peminjam</th><th>Koleksi</th><th>Tanggal</th><th class="pe-4">Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($aktivitasTerbaru as $loan)
                                <tr>
                                    <td class="ps-4"><a class="activity-name" href="{{ route('admin.peminjaman.show', $loan) }}">{{ $loan->anggota?->nama ?? 'Anggota tidak tersedia' }}</a></td>
                                    <td class="activity-collection">{{ $loan->detailPeminjaman->first()?->buku?->judul ?? '-' }}@if ($loan->detailPeminjaman->count() > 1)<span class="ms-1">+{{ $loan->detailPeminjaman->count() - 1 }}</span>@endif</td>
                                    <td class="activity-collection">{{ $loan->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="pe-4"><span class="status-pill {{ $loan->status === 'Dikembalikan' ? 'is-returned' : ($loan->is_terlambat ? 'is-late' : 'is-active') }}">{{ $loan->is_terlambat ? 'Terlambat' : $loan->status }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-5 text-center text-muted">Belum ada aktivitas peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
