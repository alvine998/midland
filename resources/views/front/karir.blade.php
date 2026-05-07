@extends('layouts.public')

@section('title', 'Karir')
@section('meta_description', 'Bergabunglah bersama tim profesional Midland Properti. Lihat lowongan pekerjaan terkini dan wujudkan karir impianmu di industri properti.')

@push('styles')
<style>
    .career-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 18px rgba(0,0,0,.07);
        transition: all .3s;
        overflow: hidden;
    }
    .career-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,.12);
    }
    .career-card .type-badge {
        font-size: .72rem;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-weight: 600;
        padding: .3rem .75rem;
        border-radius: 20px;
    }
    .career-card .deadline-tag {
        font-size: .8rem;
        color: var(--gray);
    }
    .detail-collapse .card {
        border: none;
        border-radius: 0 0 12px 12px;
        border-top: 1px solid #e5e7eb;
    }
    .apply-btn {
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: .6rem 1.5rem;
        font-weight: 600;
        transition: background .2s;
    }
    .apply-btn:hover { background: var(--primary-light); color: #fff; }
    .type-colors-full-time  { background: rgba(26,92,58,.1); color: var(--primary); }
    .type-colors-part-time  { background: rgba(14,116,144,.1); color: #0e7490; }
    .type-colors-contract   { background: rgba(161,98,7,.1);  color: #a16207; }
    .type-colors-internship { background: rgba(107,114,128,.1);color: #374151; }
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="mb-2"><i class="bi bi-briefcase me-2"></i>Karir di Midland Properti</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Karir</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Intro -->
<section class="py-5 bg-light-custom">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <span class="section-badge">Bergabung Bersama Kami</span>
                <h2 class="section-title">Wujudkan Karir Impianmu</h2>
                <div class="divider-gold"></div>
                <p class="text-muted mb-3">Midland Properti adalah tempat di mana talenta berkembang. Kami percaya bahwa karyawan yang bahagia menghasilkan layanan terbaik untuk klien kami.</p>
                <div class="d-flex flex-column gap-2">
                    @foreach([
                        ['icon'=>'graph-up-arrow','text'=>'Jenjang karir yang jelas dan terstruktur'],
                        ['icon'=>'people-fill','text'=>'Tim yang kolaboratif dan suportif'],
                        ['icon'=>'award','text'=>'Kompensasi kompetitif & bonus kinerja'],
                        ['icon'=>'mortarboard','text'=>'Program pelatihan & pengembangan berkelanjutan'],
                    ] as $b)
                    <div class="d-flex align-items-center gap-3">
                        <div class="contact-icon" style="width:36px;height:36px;font-size:1rem;flex-shrink:0">
                            <i class="bi bi-{{ $b['icon'] }}"></i>
                        </div>
                        <span style="font-size:.9rem">{{ $b['text'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="rounded-3 p-5" style="background:linear-gradient(135deg,var(--primary),var(--primary-light))">
                    <i class="bi bi-building-fill-check text-white opacity-25" style="font-size:8rem"></i>
                    <p class="text-white mt-3 mb-0 fw-semibold" style="font-size:1.1rem">Lebih dari 15 tahun melayani Indonesia</p>
                    <p class="text-white opacity-75 small">Bergabunglah dengan tim yang berpengalaman</p>
                </div>
            </div>
        </div>

        <!-- Job listings -->
        <div class="text-center mb-4">
            <span class="section-badge">Lowongan Terbuka</span>
            <h2 class="section-title">Posisi yang Tersedia</h2>
            <div class="divider-gold center"></div>
        </div>

        @if($careers->count())
        <div class="row g-3">
            @foreach($careers as $career)
            @php
                $typeClass = 'type-colors-' . $career->type;
                $typeColors = ['full-time'=>'primary','part-time'=>'info','contract'=>'warning','internship'=>'secondary'];
                $collapseId = 'career-' . $career->id;
            @endphp
            <div class="col-12">
                <div class="career-card">
                    <!-- Header row -->
                    <div class="p-4 d-flex flex-wrap align-items-start gap-3" style="background:#fff">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <h5 class="mb-0 fw-bold" style="color:var(--primary)">{{ $career->title }}</h5>
                                <span class="type-badge {{ $typeClass }}">{{ $career->getTypeLabel() }}</span>
                            </div>
                            <div class="d-flex flex-wrap gap-3" style="font-size:.85rem;color:var(--gray)">
                                @if($career->department)
                                    <span><i class="bi bi-diagram-3 me-1"></i>{{ $career->department }}</span>
                                @endif
                                @if($career->location)
                                    <span><i class="bi bi-geo-alt me-1"></i>{{ $career->location }}</span>
                                @endif
                                @if($career->deadline)
                                    <span class="{{ $career->deadline->isPast() ? 'text-danger' : '' }}">
                                        <i class="bi bi-calendar me-1"></i>Deadline: {{ $career->deadline->format('d M Y') }}
                                        {{ $career->deadline->isPast() ? '(Berakhir)' : '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm" type="button"
                                data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                aria-expanded="false">
                            <i class="bi bi-chevron-down me-1"></i>Lihat Detail
                        </button>
                    </div>

                    <!-- Collapse detail -->
                    <div class="collapse" id="{{ $collapseId }}">
                        <div class="detail-collapse">
                            <div class="card card-body p-4" style="background:#fafafa">
                                <div class="row g-4">
                                    @if($career->description)
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2" style="color:var(--primary)"><i class="bi bi-file-text me-2"></i>Deskripsi Pekerjaan</h6>
                                        <div class="text-muted" style="font-size:.9rem;white-space:pre-line">{{ $career->description }}</div>
                                    </div>
                                    @endif
                                    @if($career->requirements)
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2" style="color:var(--primary)"><i class="bi bi-check2-square me-2"></i>Persyaratan</h6>
                                        <div class="text-muted" style="font-size:.9rem;white-space:pre-line">{{ $career->requirements }}</div>
                                    </div>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    @php $waNumber = preg_replace('/\D/', '', \App\Models\Setting::get('social_whatsapp', '6281234567890')); @endphp
                                    @php $waMsg = urlencode("Halo Midland Properti,\n\nSaya tertarik melamar posisi *{$career->title}*.\n\nMohon informasi lebih lanjut. Terima kasih."); @endphp
                                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}" target="_blank" class="apply-btn btn me-2">
                                        <i class="bi bi-whatsapp me-2"></i>Lamar via WhatsApp
                                    </a>
                                    <a href="{{ route('contact') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-envelope me-2"></i>Kirim Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-briefcase" style="font-size:4rem;color:var(--primary);opacity:.15"></i>
            <p class="mt-3 text-muted">Saat ini belum ada lowongan yang tersedia.<br>Pantau terus halaman ini untuk update terbaru.</p>
        </div>
        @endif

        <!-- Spontaneous application CTA -->
        <div class="mt-5 rounded-3 p-4 p-md-5 text-center" style="background:linear-gradient(135deg,var(--primary),#0d3321)">
            <h4 class="text-white mb-2" style="font-family:'Playfair Display',serif">Tidak menemukan posisi yang cocok?</h4>
            <p class="text-white opacity-75 mb-4">Kirimkan CV dan portofolio Anda. Kami selalu mencari talenta terbaik untuk bergabung bersama tim kami.</p>
            @php $waNumberCta = preg_replace('/\D/', '', \App\Models\Setting::get('social_whatsapp', '6281234567890')); @endphp
            <a href="https://wa.me/{{ $waNumberCta }}?text={{ urlencode("Halo Midland Properti,\n\nSaya ingin mengirimkan lamaran spontan dan bergabung dengan tim Anda.") }}" target="_blank" class="btn btn-gold px-4 me-2">
                <i class="bi bi-whatsapp me-2"></i>Lamar Spontan
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light px-4">Hubungi HR</a>
        </div>

    </div>
</section>

@endsection
