@props(['book'])

<article class="public-book-card">
    <a href="{{ route('catalog.show', $book) }}" class="public-book-card__cover" style="--book-color:{{ $book->klasifikasi?->warna ?? '#1674c8' }}">
        @if ($book->cover_url)
            <img src="{{ $book->cover_url }}" alt="Sampul {{ $book->judul }}" loading="lazy">
        @else
            <span class="generated-cover">
                <small>{{ $book->klasifikasi?->kode ?? $book->kategori ?? 'STMI' }}</small>
                <strong>{{ \Illuminate\Support\Str::limit($book->judul, 42) }}</strong>
                <em>Perpustakaan STMI</em>
            </span>
        @endif
        <span class="availability-badge {{ $book->jumlah_tersedia > 0 ? 'is-available' : 'is-empty' }}">{{ $book->jumlah_tersedia > 0 ? 'Tersedia' : 'Dipinjam' }}</span>
    </a>
    <div class="public-book-card__body">
        <span class="public-book-card__type">{{ $book->kategori ?: 'Koleksi' }} @if($book->tahun_terbit) · {{ $book->tahun_terbit }}@endif</span>
        <h3><a href="{{ route('catalog.show', $book) }}">{{ $book->judul }}</a></h3>
        <p>{{ $book->penulis ?: 'Penulis belum dicatat' }}</p>
        <div class="public-book-card__meta">
            <span>{{ $book->klasifikasi?->kode ?? 'UMUM' }}</span>
            <span>{{ $book->jumlah_tersedia }}/{{ $book->jumlah_dokumen }} eksemplar</span>
        </div>
    </div>
</article>
