@extends('layouts.app')

@section('title', 'Permintaan Masuk')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Inbox Layanan</span><p>Tindak lanjuti usulan buku, pertanyaan pustakawan, aspirasi, dan pendaftaran tantangan yang dikirim dari website depan.</p></div>
        <div class="admin-page-actions"><a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Lihat Website</a></div>
    </div>

    <div class="row g-3 mb-4">
        @foreach (\App\Models\PermintaanPublik::STATUSES as $value => $label)
            <div class="col-6 col-lg-3">
                <a href="{{ route('admin.permintaan.index', ['status' => $value]) }}" class="card request-stat-card h-100 text-decoration-none text-dark">
                    <div class="card-body"><div class="text-muted small text-uppercase fw-bold">{{ $label }}</div><div class="h2 mb-0 mt-2">{{ number_format($statusCounts[$value] ?? 0) }}</div></div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card admin-filter-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-5"><select name="type" class="form-select"><option value="">Semua jenis</option>@foreach(\App\Models\PermintaanPublik::TYPES as $value => $label)<option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-4"><select name="status" class="form-select"><option value="">Semua status</option>@foreach(\App\Models\PermintaanPublik::STATUSES as $value => $label)<option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-3 d-flex gap-2"><button class="btn btn-outline-primary flex-fill">Filter</button><a href="{{ route('admin.permintaan.index') }}" class="btn btn-outline-secondary">Reset</a></div>
            </form>
        </div>
    </div>

    <div class="card admin-data-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th class="ps-4">Pengirim</th><th>Jenis</th><th>Subjek</th><th>Masuk</th><th>Status</th><th class="text-end pe-4">Aksi</th></tr></thead>
                <tbody>
                    @forelse($requests as $item)
                        <tr class="{{ $item->status === 'baru' ? 'fw-semibold' : '' }}">
                            <td class="ps-4"><div>{{ $item->name }}</div><small class="text-muted">{{ $item->email ?: $item->phone }}</small></td>
                            <td><span class="badge text-bg-light border">{{ $item->type_label }}</span></td>
                            <td>{{ \Illuminate\Support\Str::limit($item->subject, 48) }}</td>
                            <td>{{ $item->created_at?->diffForHumans() }}</td>
                            <td><span class="badge {{ match($item->status) {'baru'=>'text-bg-danger','diproses'=>'text-bg-warning text-dark','selesai'=>'text-bg-success',default=>'text-bg-secondary'} }}">{{ $item->status_label }}</span></td>
                            <td class="text-end pe-4"><a href="{{ route('admin.permintaan.show', $item) }}" class="btn btn-sm btn-outline-primary">Buka</a></td>
                        </tr>
                    @empty<tr><td colspan="6" class="py-5 text-center text-muted">Belum ada permintaan.</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())<div class="card-body border-top">{{ $requests->links('pagination::bootstrap-5') }}</div>@endif
    </div>
@endsection
