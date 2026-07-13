<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pengingat Pengembalian</title>
</head>
<body style="margin:0;background:#f1f5f9;font-family:Arial,sans-serif;color:#10243d">
    <div style="max-width:620px;margin:0 auto;padding:32px 18px">
        <div style="background:#052951;color:#fff;padding:28px;border-radius:18px 18px 0 0">
            <div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#9dd4ff">Perpustakaan Politeknik STMI Jakarta</div>
            <h1 style="margin:10px 0 0;font-size:25px">Pengingat pengembalian koleksi</h1>
        </div>
        <div style="background:#fff;padding:30px;border-radius:0 0 18px 18px">
            <p>Halo <strong>{{ $loan->anggota?->nama }}</strong>,</p>
            <p>Peminjaman Anda akan jatuh tempo pada <strong>{{ $loan->tanggal_kembali?->translatedFormat('d F Y') }}</strong>.</p>
            <ul style="padding-left:20px">
                @foreach ($loan->detailPeminjaman->where('status_item', 'Dipinjam') as $detail)
                    <li style="margin-bottom:8px">{{ $detail->buku?->judul ?? 'Koleksi' }}</li>
                @endforeach
            </ul>
            <p>Silakan kembalikan atau hubungi petugas sebelum jatuh tempo untuk menghindari keterlambatan.</p>
            <p style="margin:26px 0 0;color:#607187;font-size:13px">Email ini dikirim otomatis karena pengingat layanan diaktifkan pada data anggota Anda.</p>
        </div>
    </div>
</body>
</html>
