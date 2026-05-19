@extends('layouts.admin')
@section('title', 'Kelola Halaman')

@section('content')
<div class="mb-4">
    <div class="page-title">Kelola Halaman</div>
    <div class="page-subtitle">Edit konten untuk setiap halaman website</div>
</div>

<div class="row g-3">
    @foreach([
        ['slug' => 'home',    'label' => 'Beranda (Home)',      'icon' => 'house',         'desc' => 'Hero section, judul utama, dan konten halaman utama'],
        ['slug' => 'project', 'label' => 'Proyek (Project)',    'icon' => 'buildings',     'desc' => 'Judul dan deskripsi halaman proyek'],
        ['slug' => 'gallery', 'label' => 'Galeri (Gallery)',    'icon' => 'images',        'desc' => 'Judul dan deskripsi halaman galeri'],
        ['slug' => 'about',   'label' => 'Tentang Kami (About)','icon' => 'info-circle',   'desc' => 'Konten halaman tentang perusahaan'],
        ['slug' => 'contact', 'label' => 'Kontak (Contact)',    'icon' => 'telephone',     'desc' => 'Deskripsi halaman kontak'],
        ['slug' => 'karir',   'label' => 'Karir (Career)',      'icon' => 'briefcase',     'desc' => 'Intro, poin keunggulan, dan teks CTA halaman karir'],
    ] as $page)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div style="width:45px;height:45px;background:rgba(26,60,94,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-{{ $page['icon'] }}" style="color:var(--primary);font-size:1.2rem"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-semibold" style="color:var(--primary)">{{ $page['label'] }}</h6>
                        <p class="text-muted small mb-0">{{ $page['desc'] }}</p>
                    </div>
                </div>
                @if(isset($pages[$page['slug']]))
                    <div class="d-flex align-items-center gap-1 mb-3">
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <i class="bi bi-check-circle me-1"></i>Sudah dikonfigurasi
                        </span>
                    </div>
                @else
                    <div class="mb-3">
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                            <i class="bi bi-exclamation-circle me-1"></i>Belum dikonfigurasi
                        </span>
                    </div>
                @endif
                <a href="{{ route('admin.pages.edit', $page['slug']) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-pencil me-2"></i>Edit Konten
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
