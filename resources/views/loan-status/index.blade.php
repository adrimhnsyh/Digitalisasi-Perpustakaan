@extends('layouts.public')

@section('title', 'Cek Peminjaman')
@section('description', 'Cek status, tenggat, dan riwayat peminjaman koleksi Anda.')

@section('content')
    <main>
        <section class="page-hero loan-status-hero"><div class="container"><p class="eyebrow mb-2">Layanan Anggota</p><h1 class="page-title mb-3">Cek peminjaman Anda.</h1><p class="mb-0">Gunakan nomor identitas dan empat digit terakhir telepon yang terdaftar.</p></div></section>
        <section class="loan-status-section">
            <div class="container">
                <div class="row g-5 align-items-start">
                    <div class="col-lg-4">
                        <form action="{{ route('loan-status.check') }}" method="POST" class="member-check-form">
                            @csrf
                            <span class="member-check-form__icon"><i class="bi bi-person-vcard"></i></span>
                            <h2>Verifikasi anggota</h2>
                            <p>Data ini hanya digunakan untuk mencocokkan keanggotaan.</p>
                            @if($errors->any())<div class="alert alert-danger small">{{ $errors->first() }}</div>@endif
                            <div class="mb-3"><label for="no_identitas" class="form-label">NIM / NIP / Nomor Identitas</label><input id="no_identitas" name="no_identitas" class="form-control" value="{{ old('no_identitas') }}" required></div>
                            <div class="mb-4"><label for="phone_last_four" class="form-label">4 digit terakhir telepon</label><input id="phone_last_four" name="phone_last_four" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" class="form-control" required></div>
                            <button class="button catalog-filter__button w-100" type="submit">Tampilkan Peminjaman</button>
                        </form>
                    </div>
                    <div class="col-lg-8">
                        @if($member)
                            <div class="loan-member-heading"><div><span>Data ditemukan</span><h2>{{ $member->nama }}</h2><p>{{ $member->status }} · Anggota #{{ $member->no_anggota }}</p></div><span class="loan-member-heading__status"><i class="bi bi-shield-check"></i>Terverifikasi</span></div>
                            <div class="loan-history-list">
                                @forelse($loans as $loan)
                                    <article class="loan-history-card {{ $loan->is_terlambat ? 'is-late' : '' }}">
                                        <div class="loan-history-card__top"><div><span>Transaksi #{{ $loan->id_peminjaman }}</span><h3>{{ $loan->tanggal_pinjam?->translatedFormat('d F Y') }}</h3></div><span class="loan-status-pill {{ $loan->status === 'Dikembalikan' ? 'is-returned' : ($loan->is_terlambat ? 'is-late' : 'is-active') }}">{{ $loan->is_terlambat ? 'Terlambat' : $loan->status }}</span></div>
                                        <div class="loan-history-card__due"><span>Batas pengembalian</span><strong>{{ $loan->tanggal_kembali?->translatedFormat('d F Y') ?? '-' }}</strong></div>
                                        <div class="loan-book-list">@foreach($loan->detailPeminjaman as $detail)<div><i class="bi bi-book"></i><span><strong>{{ $detail->buku?->judul ?? 'Koleksi tidak tersedia' }}</strong><small>{{ $detail->status_item }} · {{ $detail->jumlah_pinjam }} eksemplar</small></span></div>@endforeach</div>
                                    </article>
                                @empty<div class="empty-public-state empty-public-state--large"><i class="bi bi-journal-check"></i><h2>Belum ada riwayat peminjaman</h2><p>Transaksi Anda akan tampil di sini setelah dicatat oleh petugas.</p></div>@endforelse
                            </div>
                        @else
                            <div class="loan-placeholder"><div class="loan-placeholder__visual"><i class="bi bi-journal-bookmark"></i></div><h2>Status koleksi dalam satu tempat.</h2><p>Setelah data cocok, Anda dapat melihat buku yang sedang dipinjam, batas pengembalian, status keterlambatan, dan riwayat transaksi.</p><div class="loan-placeholder__features"><span><i class="bi bi-calendar-check"></i>Tenggat pengembalian</span><span><i class="bi bi-clock-history"></i>Riwayat transaksi</span><span><i class="bi bi-bell"></i>Pengingat email</span></div></div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
