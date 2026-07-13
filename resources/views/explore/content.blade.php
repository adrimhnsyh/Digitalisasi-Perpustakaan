@extends('layouts.public')

@section('title', $konten->title)
@section('description', \Illuminate\Support\Str::limit($konten->excerpt ?: $konten->body, 155))

@section('content')
    <main>
        <section class="page-hero content-detail-hero"><div class="container"><p class="eyebrow mb-2">{{ $konten->type_label }}</p><h1 class="page-title mb-3">{{ $konten->title }}</h1>@if($konten->excerpt)<p class="mb-0">{{ $konten->excerpt }}</p>@endif</div></section>
        <section class="content-detail-section">
            <div class="container">
                <div class="row justify-content-center"><div class="col-lg-9">
                    @if($konten->image_url)<img src="{{ $konten->image_url }}" class="content-detail-image" alt="{{ $konten->title }}">@endif
                    <article class="content-detail-card">
                        <div class="content-detail-meta"><span><i class="bi bi-tag"></i>{{ $konten->type_label }}</span>@if($konten->event_at)<span><i class="bi bi-calendar3"></i>{{ $konten->event_at->translatedFormat('d F Y, H.i') }} WIB</span>@elseif($konten->published_at)<span><i class="bi bi-clock"></i>{{ $konten->published_at->translatedFormat('d F Y') }}</span>@endif</div>
                        <div class="content-detail-body">{{ $konten->body ?: $konten->excerpt }}</div>
                        <div class="content-detail-actions">@if($konten->attachment_url)<a class="button catalog-filter__button" href="{{ $konten->attachment_url }}"><i class="bi bi-download"></i>Unduh lampiran</a>@endif @if($konten->external_url)<a class="button button-outline-navy" href="{{ str_starts_with($konten->external_url, '/') ? url($konten->external_url) : $konten->external_url }}" @unless(str_starts_with($konten->external_url, '/')) target="_blank" rel="noopener noreferrer" @endunless>Buka tautan <i class="bi bi-arrow-up-right"></i></a>@endif</div>
                    </article>
                </div></div>
            </div>
        </section>
        @if($relatedContent->isNotEmpty())<section class="related-content"><div class="container"><p class="section-kicker">Informasi terkait</p><div class="row g-4">@foreach($relatedContent as $item)<div class="col-md-4"><a href="{{ route('public-content.show', $item) }}" class="information-card"><span>{{ $item->type_label }}</span><h2>{{ $item->title }}</h2><p>{{ $item->excerpt }}</p><em>Selengkapnya <i class="bi bi-arrow-right"></i></em></a></div>@endforeach</div></div></section>@endif
    </main>
@endsection
