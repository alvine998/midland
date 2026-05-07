@extends('layouts.public')
@section('title', 'Berita')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1>{{ $page->hero_title ?? 'Berita Terbaru' }}</h1>
        @if($page->hero_subtitle ?? false)
            <p style="color:rgba(255,255,255,0.75);max-width:600px">{{ $page->hero_subtitle }}</p>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $menu_home ?? 'Home' }}</a></li>
                <li class="breadcrumb-item active">Berita</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5 bg-light-custom">
    <div class="container">
        @if($articles->count())
            <div class="row g-4">
                @foreach($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm" style="transition:all 0.3s">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $article->title }}" loading="lazy" width="400" height="200">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height:200px;background:linear-gradient(135deg,rgba(26,92,58,0.1),rgba(42,138,82,0.1))">
                                <i class="bi bi-newspaper" style="font-size:3rem;color:rgba(26,92,58,0.3)"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex gap-2 mb-2">
                                @if($article->published_at)
                                    <small class="text-muted">{{ $article->published_at->format('d M Y') }}</small>
                                @endif
                                @if($article->author)
                                    <small class="text-muted">{{ $article->author }}</small>
                                @endif
                            </div>
                            <h5 class="card-title" style="color:var(--primary)">{{ $article->title }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1">
                                {{ $article->excerpt ? Str::limit($article->excerpt, 100) : Str::limit(strip_tags($article->content), 100) }}
                            </p>
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-sm btn-gold">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-newspaper text-muted" style="font-size:4rem;opacity:0.3"></i>
                <p class="text-muted mt-3">Belum ada berita yang dipublikasikan.</p>
            </div>
        @endif
    </div>
</section>
@endsection
