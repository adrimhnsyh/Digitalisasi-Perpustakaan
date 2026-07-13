@extends('layouts.app')

@section('title', 'Konten Publik')

@section('content')
    <div class="admin-page-intro">
        <div class="admin-page-intro__copy"><span class="admin-page-intro__eyebrow">Publikasi Website</span><p>Siapkan berita, agenda, FAQ, panduan, dan konten yang akan dibaca pengunjung di website depan.</p></div>
        <div class="admin-page-actions"><a href="{{ route('admin.konten.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tambah Konten</a></div>
    </div>

    <div class="card admin-filter-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-5">
                    <select name="type" class="form-select">
                        <option value="">Semua jenis konten</option>
                        @foreach (\App\Models\KontenPublik::TYPES as $value => $label)<option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        <option value="published" @selected($status === 'published')>Terbit</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2"><button class="btn btn-outline-primary flex-fill">Filter</button><a class="btn btn-outline-secondary" href="{{ route('admin.konten.index') }}">Reset</a></div>
            </form>
        </div>
    </div>

    <div class="card admin-data-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th class="ps-4">Konten</th><th>Jenis</th><th>Tanggal</th><th>Status</th><th class="text-end pe-4">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($contents as $item)
                        <tr>
                            <td class="ps-4"><div class="fw-semibold">{{ $item->title }}</div><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->excerpt ?: $item->body, 72) }}</small></td>
                            <td><span class="badge text-bg-light border">{{ $item->type_label }}</span>@if($item->is_featured)<span class="badge text-bg-warning text-dark ms-1">Unggulan</span>@endif</td>
                            <td>{{ $item->event_at?->format('d/m/Y H:i') ?? $item->published_at?->format('d/m/Y') ?? '-' }}</td>
                            <td><span class="badge {{ $item->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->is_published ? 'Terbit' : 'Draft' }}</span></td>
                            <td class="text-end pe-4 text-nowrap">
                                @if($item->is_published)<a href="{{ route('public-content.show', $item) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>@endif
                                <a href="{{ route('admin.konten.edit', $item) }}" class="btn btn-sm btn-outline-secondary ms-1"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.konten.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger ms-1"><i class="fa-solid fa-trash"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-5 text-center text-muted">Belum ada konten yang sesuai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contents->hasPages())<div class="card-body border-top">{{ $contents->links('pagination::bootstrap-5') }}</div>@endif
    </div>
@endsection
