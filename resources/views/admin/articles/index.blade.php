@extends('layouts.admin')
@section('title', 'Kelola Berita')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <div class="page-title">Kelola Berita</div>
        <div class="page-subtitle">Daftar semua berita</div>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Berita
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background:var(--light-bg)">
                <tr>
                    <th style="width:40px">
                        <i class="bi bi-image"></i>
                    </th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Dipublikasikan</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            @if($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px" alt="">
                            @else
                                <div style="width:40px;height:40px;background:var(--light-bg);border-radius:4px;display:flex;align-items:center;justify-content:center">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $article->title }}</strong>
                            <br><span class="text-muted small">{{ Str::limit($article->excerpt ?? $article->content, 60) }}</span>
                        </td>
                        <td class="text-muted small">{{ $article->author ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $article->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $article->getStatusLabel() }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size:2rem;opacity:0.3"></i>
                            <p class="mb-0">Belum ada berita</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($articles->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links() }}
    </div>
@endif
@endsection
