@extends('layouts.public')
@section('title', 'Beranda')

@section('content')
<!-- Hero Section with Video -->
<section class="hero-section">
    @if(!empty($page->video_url))
        <video autoplay muted loop playsinline style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0">
            <source src="{{ $page->video_url }}" type="video/mp4">
        </video>
    @elseif(!empty($page->hero_image))
        <div class="hero-bg" style="background-image: url('{{ asset('storage/' . $page->hero_image) }}')"></div>
    @endif
    <div class="hero-overlay"></div>
    <div class="container hero-content py-5" style="position:relative;z-index:1">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-7">
                <div class="hero-badge">Agen Properti Terpercaya</div>
                <h1 class="hero-title">
                    {{ $page->hero_title ?? 'Temukan Properti' }}<br>
                    <span>{{ $page->hero_subtitle ?? 'Impian Anda' }}</span>
                </h1>
                <p class="hero-subtitle">
                    {{ $page->content ?? 'Midland Properti hadir dengan ratusan pilihan properti terbaik — rumah, apartemen, komersial, dan tanah di lokasi strategis.' }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('project') }}" class="btn btn-gold">
                        <i class="bi bi-building me-2"></i>Lihat Proyek
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light-custom">
                        <i class="bi bi-telephone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-number">500+</div>
                <div class="stat-label">Properti Terjual</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">{{ \App\Models\Project::count() }}+</div>
                <div class="stat-label">Proyek Aktif</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">15+</div>
                <div class="stat-label">Tahun Pengalaman</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Klien Puas</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Projects -->
@if($featured->count())
<section class="py-5 bg-light-custom">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Unggulan</span>
            <h2 class="section-title">Proyek Pilihan Kami</h2>
            <div class="divider-gold center"></div>
            <p class="text-muted mx-auto" style="max-width:500px">Temukan properti unggulan kami yang dipilih dengan cermat untuk memenuhi berbagai kebutuhan Anda.</p>
        </div>
        <div class="row g-4">
            @foreach($featured as $project)
            <div class="col-md-6 col-lg-4">
                <div class="card project-card h-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}">
                    @elseif(!empty($project->images) && is_array($project->images) && count($project->images) > 0)
                        <img src="{{ asset('storage/' . $project->images[0]) }}" class="card-img-top" alt="{{ $project->title }}">
                    @else
                        <div class="card-img-placeholder"><i class="bi bi-building"></i></div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            @if($project->type)
                                <span class="badge bg-primary bg-opacity-10 text-primary badge-status">{{ ucfirst($project->type) }}</span>
                            @endif
                            <span class="badge {{ $project->status === 'available' ? 'bg-success' : ($project->status === 'upcoming' ? 'bg-warning text-dark' : 'bg-secondary') }} badge-status">
                                {{ $project->status === 'available' ? 'Tersedia' : ($project->status === 'upcoming' ? 'Segera' : 'Terjual') }}
                            </span>
                        </div>
                        <h5 class="card-title">{{ $project->title }}</h5>
                        @if($project->location)
                            <p class="location mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $project->location }}</p>
                        @endif
                        @if($project->price)
                            <p class="price mb-3">{{ $project->price }}</p>
                        @endif
                        @if($project->description)
                            <p class="text-muted small mb-3">{{ Str::limit($project->description, 90) }}</p>
                        @endif
                        <a href="{{ route('project.show', $project->slug) }}" class="btn btn-gold btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('project') }}" class="btn btn-outline-primary px-4 py-2">Lihat Semua Proyek <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>
@endif

<!-- Why Us -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-badge">Mengapa Kami</span>
                <h2 class="section-title">Dipercaya oleh Ribuan Keluarga Indonesia</h2>
                <div class="divider-gold"></div>
                <p class="text-muted mb-4">Midland Properti telah melayani pelanggan selama lebih dari satu dekade dengan komitmen terhadap kualitas, kepercayaan, dan kepuasan klien.</p>
                <div class="row g-3">
                    @foreach([
                        ['icon' => 'shield-check', 'title' => 'Terpercaya & Berpengalaman', 'desc' => 'Lebih dari 15 tahun melayani kebutuhan properti Indonesia.'],
                        ['icon' => 'geo-alt', 'title' => 'Lokasi Strategis', 'desc' => 'Properti di lokasi terbaik dengan aksesibilitas tinggi.'],
                        ['icon' => 'people', 'title' => 'Tim Profesional', 'desc' => 'Agen berpengalaman siap membantu Anda 24/7.'],
                        ['icon' => 'award', 'title' => 'Penghargaan Bergengsi', 'desc' => 'Meraih berbagai penghargaan sebagai agen properti terbaik.'],
                    ] as $item)
                    <div class="col-6">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <div class="contact-icon" style="width:40px;height:40px;font-size:1.1rem">
                                    <i class="bi bi-{{ $item['icon'] }}"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1" style="color:var(--primary);font-size:0.9rem">{{ $item['title'] }}</h6>
                                <p class="text-muted small mb-0">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="rounded-3 overflow-hidden" style="height:200px;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-buildings text-white opacity-25" style="font-size:5rem"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-3 overflow-hidden" style="height:200px;background:linear-gradient(135deg,var(--gold),var(--gold-light));display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-house-heart text-white opacity-50" style="font-size:5rem"></i>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rounded-3 p-4" style="background:var(--light-bg)">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact-icon" style="width:55px;height:55px;font-size:1.5rem;background:var(--gold);color:var(--primary)">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Butuh konsultasi gratis?</div>
                                    <div class="fw-semibold" style="color:var(--primary)">{{ \App\Models\Setting::get('contact_phone', '+62 xxx-xxxx-xxxx') }}</div>
                                </div>
                                <a href="{{ route('contact') }}" class="btn btn-gold ms-auto">Hubungi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
@if($testimonials->count())
<section class="py-5 bg-light-custom">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">Testimoni</span>
            <h2 class="section-title">Apa Kata Klien Kami</h2>
            <div class="divider-gold center"></div>
            <p class="text-muted mx-auto" style="max-width:500px">Kepuasan klien adalah prioritas utama kami. Berikut pengalaman nyata dari mereka yang telah mempercayakan kebutuhan propertinya kepada kami.</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($testimonials as $t)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-4" style="border-radius:12px">
                    <!-- Stars -->
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}" style="color:var(--gold);font-size:.9rem"></i>
                        @endfor
                    </div>
                    <!-- Quote -->
                    <p class="text-muted mb-4" style="font-size:.92rem;line-height:1.7;flex:1">
                        <i class="bi bi-quote text-gold opacity-50 me-1" style="font-size:1.2rem"></i>{{ $t->content }}
                    </p>
                    <!-- Author -->
                    <div class="d-flex align-items-center gap-3">
                        @if($t->photo)
                            <img src="{{ asset('storage/' . $t->photo) }}" alt="{{ $t->name }}" class="rounded-circle" style="width:48px;height:48px;object-fit:cover;flex-shrink:0">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:48px;height:48px;background:var(--primary);color:#fff;font-size:1.1rem;font-weight:700">
                                {{ strtoupper(substr($t->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="fw-semibold" style="color:var(--primary)">{{ $t->name }}</div>
                            @if($t->position)
                                <div class="text-muted" style="font-size:.8rem">{{ $t->position }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="cta-section py-5">    <div class="container text-center py-3">
        <h2 class="text-white mb-3" style="font-family:'Playfair Display',serif">Siap Menemukan Properti Impian Anda?</h2>
        <p class="text-white-50 mb-4">Hubungi tim kami sekarang dan dapatkan konsultasi gratis bersama agen properti profesional kami.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('project') }}" class="btn btn-gold px-4">Jelajahi Proyek</a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light px-4">Konsultasi Gratis</a>
        </div>
    </div>
</section>
@endsection
