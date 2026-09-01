<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Midland Properti - Agen Properti Terpercaya') | {{ $site_name ?? 'Midland Properti' }}</title>
    <meta name="description" content="@yield('meta_description', 'Midland Properti adalah agen properti terpercaya dengan berbagai pilihan rumah, apartemen, ruko, dan kavling di Jakarta.')">
    <meta name="keywords" content="properti, rumah, apartemen, ruko, kavling, jual beli properti, agen properti jakarta">
    <meta name="author" content="Midland Properti">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Open Graph -->
    <meta property="og:site_name" content="Midland Properti">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Midland Properti - Agen Properti Terpercaya')">
    <meta property="og:description" content="@yield('meta_description', 'Midland Properti adalah agen properti terpercaya dengan berbagai pilihan rumah, apartemen, ruko, dan kavling di Jakarta.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', url('images/og-image.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Midland Properti - Agen Properti Terpercaya')">
    <meta name="twitter:description" content="@yield('meta_description', 'Midland Properti adalah agen properti terpercaya dengan berbagai pilihan rumah, apartemen, ruko, dan kavling di Jakarta.')">
    <meta name="twitter:image" content="@yield('og_image', url('images/og-image.png'))">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a5c3a;
            --primary-light: #2a8a52;
            --gold: #c9a84c;
            --gold-light: #e8c97a;
            --dark: #111827;
            --gray: #6b7280;
            --light-bg: #f3f8f5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: #fff;
        }

        h1,
        h2,
        h3,
        h4,
        .display-1,
        .display-2,
        .display-3,
        .display-4 {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar */
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--gold) !important;
        }

        .navbar-brand span {
            color: #fff;
        }

        .main-navbar {
            background: var(--primary) !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
        }

        .main-navbar .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem;
            transition: color 0.2s;
        }

        .main-navbar .nav-link:hover,
        .main-navbar .nav-link.active {
            color: var(--gold) !important;
        }

        .main-navbar .nav-link.active {
            border-bottom: 2px solid var(--gold);
        }

        .navbar-toggler {
            border-color: rgba(201, 168, 76, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28201,168,76,0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Hero */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, #0d3321 100%);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url('/images/hero-pattern.svg') center/cover no-repeat;
            opacity: 0.05;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(26, 92, 58, 0.92) 50%, rgba(26, 92, 58, 0.6) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
            background: var(--gold);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 0.35rem 1rem;
            border-radius: 2px;
            margin-bottom: 1.2rem;
        }

        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            color: #fff;
            line-height: 1.15;
            margin-bottom: 1.2rem;
        }

        .hero-title span {
            color: var(--gold);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 550px;
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .btn-gold {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 3px;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background: var(--gold-light);
            border-color: var(--gold-light);
            color: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(201, 168, 76, 0.4);
        }

        .nav-link.btn-gold.active {
            color: var(--primary) !important;
            background: var(--gold);
            border-bottom: none;
        }

        .btn-outline-light-custom {
            border: 2px solid rgba(255, 255, 255, 0.4);
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 3px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .btn-outline-light-custom:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        /* Stats Bar */
        .stats-bar {
            background: var(--gold);
            padding: 1.5rem 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        /* Section */
        .section-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            color: var(--primary);
        }

        .divider-gold {
            width: 60px;
            height: 3px;
            background: var(--gold);
            margin: 1rem 0 1.5rem;
        }

        .divider-gold.center {
            margin-left: auto;
            margin-right: auto;
        }

        /* Project Card */
        .project-card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
        }

        .project-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .project-card .card-img-top {
            height: 220px;
            object-fit: cover;
        }

        .project-card .card-img-placeholder {
            height: 220px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.3);
            font-size: 4rem;
        }

        .project-card .badge-status {
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .project-card .price {
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            font-size: 1.15rem;
            font-weight: 700;
        }

        .project-card .card-title {
            color: var(--primary);
            font-size: 1.05rem;
            margin-bottom: 0.25rem;
        }

        .project-card .location {
            color: var(--gray);
            font-size: 0.85rem;
        }

        /* Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 6px;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s;
        }

        .gallery-item:hover img {
            transform: scale(1.06);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(26, 60, 94, 0.7);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay i {
            font-size: 2rem;
            color: var(--gold);
        }

        /* CTA */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, #0d3321 100%);
        }

        /* Footer */
        footer {
            background: #061c12;
        }

        footer .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--gold);
        }

        footer p,
        footer a {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.9rem;
        }

        footer a:hover {
            color: var(--gold);
            text-decoration: none;
        }

        footer h6 {
            color: #fff;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        footer .footer-divider {
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Breadcrumb */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #0d3321 100%);
            padding: 5rem 0 3rem;
        }

        .page-header h1 {
            color: #fff;
            font-size: 2.5rem;
        }

        .page-header .breadcrumb-item,
        .page-header .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .page-header .breadcrumb-item.active {
            color: var(--gold);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.4);
        }

        /* Contact */
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(201, 168, 76, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(201, 168, 76, 0.2);
        }

        /* Utilities */
        .bg-light-custom {
            background: var(--light-bg);
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .text-primary-custom {
            color: var(--primary) !important;
        }

        .min-vh-75 {
            min-height: 75vh;
        }

        html { overflow-x: hidden; }
        body { overflow-x: hidden; }
        img { max-width: 100%; }

        /* ── Navbar mobile ─────────────────────────────────────────────── */
        @media (max-width: 991.98px) {
            .main-navbar .navbar-collapse {
                background: var(--primary);
                padding: 1rem 0 .75rem;
                margin-top: .75rem;
                border-top: 1px solid rgba(255, 255, 255, .08);
            }
            .main-navbar .nav-item { width: 100%; }
            .main-navbar .nav-link {
                padding: .65rem 0 !important;
            }
            .main-navbar .nav-link.active {
                border-bottom: none;
                color: var(--gold) !important;
                border-left: 3px solid var(--gold);
                padding-left: .75rem !important;
            }
            .main-navbar .nav-link.btn-gold {
                margin-left: 0 !important;
                margin-top: .5rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: .6rem 1.25rem !important;
                border-left: none;
                text-align: center;
            }
            .main-navbar .nav-link.btn-gold.active {
                border-left: none;
                padding-left: 1.25rem !important;
            }
        }

        @media (max-width: 767.98px) {
            /* ── Hero ── */
            .hero-section {
                min-height: auto;
                padding: 3.5rem 0 3rem;
                align-items: flex-start;
            }
            .hero-section .min-vh-75 {
                min-height: auto !important;
            }
            .hero-overlay {
                background: linear-gradient(to bottom, rgba(26, 92, 58, .88) 0%, rgba(13, 51, 33, .92) 100%);
            }
            .hero-badge {
                font-size: .7rem;
                letter-spacing: 1.5px;
                padding: .3rem .8rem;
            }
            .hero-title {
                font-size: clamp(1.85rem, 8vw, 2.5rem);
                line-height: 1.2;
            }
            .hero-subtitle {
                font-size: .95rem;
                line-height: 1.65;
            }
            .hero-content .d-flex.flex-wrap {
                flex-direction: column;
            }
            .hero-content .btn-gold,
            .hero-content .btn-outline-light-custom {
                width: 100%;
                justify-content: center;
                text-align: center;
                padding: .8rem 1.5rem;
            }
            /* ── Stats ── */
            .stats-bar { padding: 1.25rem 0; }
            .stat-number { font-size: 1.6rem; }
            .stat-label { font-size: .72rem; }
            /* ── Sections ── */
            .section-title { font-size: clamp(1.5rem, 6vw, 1.9rem); }
            .page-header { padding: 2.5rem 0 2rem; }
            .page-header h1 { font-size: 1.75rem; line-height: 1.25; }
            .page-header .breadcrumb { flex-wrap: wrap; }
            /* ── Cards ── */
            .project-card .card-img-top,
            .project-card .card-img-placeholder { height: 200px; }
            /* ── Gallery ── */
            .gallery-item img { height: 180px; }
            /* ── CTA ── */
            .cta-section h2 { font-size: 1.5rem; }
            .cta-section p { font-size: .9rem; }
            /* ── Footer ── */
            footer .d-flex.flex-wrap.justify-content-between {
                flex-direction: column;
                gap: .5rem;
                text-align: center;
            }
        }

        @media (max-width: 575.98px) {
            .container { padding-left: 1rem; padding-right: 1rem; }
            .hero-section { padding: 2.5rem 0 2.5rem; }
            .hero-title { font-size: 1.75rem; }
            .stats-bar .stat-number { font-size: 1.45rem; }
            .project-card .card-img-top,
            .project-card .card-img-placeholder { height: 190px; }
            .gallery-item img { height: 160px; }
            section.py-5 { padding-top: 2.5rem !important; padding-bottom: 2.5rem !important; }
            .page-header { padding: 2rem 0 1.5rem; }
            .page-header h1 { font-size: 1.6rem; }
            /* Stack WhyUs consultation box */
            .whyus-contact-box {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .whyus-contact-box .btn {
                width: 100%;
                margin-left: 0 !important;
            }
        }

        @media (max-width: 375px) {
            .hero-title { font-size: 1.55rem; }
            .btn-gold, .btn-outline-light-custom { font-size: .9rem; }
            .stat-number { font-size: 1.3rem; }
        }

        /* ── Chat widget mobile tuning ─────────────────────────────────── */
        @media (max-width: 480px) {
            #chat-bubble {
                bottom: calc(20px + env(safe-area-inset-bottom, 0px));
                right: 16px;
                width: 52px;
                height: 52px;
            }
            #chat-panel {
                bottom: calc(80px + env(safe-area-inset-bottom, 0px));
                right: 8px;
                left: 8px;
                width: auto;
                max-width: none;
                height: min(70vh, 520px);
                max-height: calc(100dvh - 96px);
            }
        }

        footer a { word-break: break-word; }

        /* ── Property detail / project detail mobile tweaks ──────────────── */
        @media (max-width: 767.98px) {
            .row.g-5 { --bs-gutter-y: 1.75rem; }
            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            .nav-tabs::-webkit-scrollbar { display: none; }
            .nav-tabs .nav-link { white-space: nowrap; font-size: .9rem; }
            .sticky-top { position: static !important; }
            /* CTA buttons stack on very narrow */
            .cta-section .d-flex.justify-content-center {
                flex-direction: column;
                align-items: stretch;
            }
            .cta-section .d-flex.justify-content-center .btn {
                width: 100%;
            }
        }
        @media (max-width: 575.98px) {
            .whyus-visual-box { height: 160px !important; }
            .card-body.p-4 { padding: 1.25rem !important; }
        }
    </style>
    @stack('styles')
    <!-- JSON-LD Schema -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Midland Properti",
            "description": "Agen properti terpercaya dengan berbagai pilihan properti terbaik",
            "image": "{{ asset('images/logo.png') }}",
            "url": "{{ route('home') }}",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{ \App\Models\Setting::get('contact_address', 'Jl. Sudirman No. 88, Jakarta Pusat 10220') }}",
                "addressCountry": "ID"
            },
            "telephone": "{{ \App\Models\Setting::get('contact_phone', '+62 21-1234-5678') }}",
            "email": "{{ \App\Models\Setting::get('contact_email', 'info@midlandproperti.com') }}",
            "sameAs": [
                "{{ \App\Models\Setting::get('social_facebook', '') }}",
                "{{ \App\Models\Setting::get('social_instagram', '') }}"
            ]
        }
    </script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg main-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Midland <span>Properti</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                <ul class="navbar-nav gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            {{ $menu_home ?? 'Beranda' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('project*') ? 'active' : '' }}" href="{{ route('project') }}">
                            {{ $menu_project ?? 'Proyek' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">
                            {{ $menu_gallery ?? 'Galeri' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            {{ $menu_about ?? 'Tentang Kami' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            {{ $menu_contact ?? 'Kontak' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('articles*') ? 'active' : '' }}" href="{{ route('articles') }}">
                            {{ $menu_articles ?? 'Berita' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('karir') ? 'active' : '' }}" href="{{ route('karir') }}">
                            Karir
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-gold px-3 ms-2 rounded-1 {{ request()->routeIs('simulasi-cicilan') ? 'active' : '' }}" href="{{ route('simulasi-cicilan') }}">
                            <i class="bi bi-calculator me-1"></i>Simulasi Cicilan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand mb-3">Midland Properti</div>
                    <p class="mb-3">{{ $site_tagline ?? 'Your Trusted Property Partner' }}. Kami berkomitmen menghadirkan properti terbaik untuk Anda dan keluarga.</p>
                    <div class="d-flex gap-3">
                        @php $instagram = \App\Models\Setting::get('social_instagram'); $facebook = \App\Models\Setting::get('social_facebook'); $whatsapp = \App\Models\Setting::get('social_whatsapp'); @endphp
                        @if($instagram)<a href="{{ $instagram }}" target="_blank"><i class="bi bi-instagram fs-5"></i></a>@endif
                        @if($facebook)<a href="{{ $facebook }}" target="_blank"><i class="bi bi-facebook fs-5"></i></a>@endif
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}" target="_blank"><i class="bi bi-whatsapp fs-5"></i></a>@endif
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6>Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-1"><a href="{{ route('home') }}">{{ $menu_home ?? 'Beranda' }}</a></li>
                        <li class="mb-1"><a href="{{ route('project') }}">{{ $menu_project ?? 'Proyek' }}</a></li>
                        <li class="mb-1"><a href="{{ route('gallery') }}">{{ $menu_gallery ?? 'Galeri' }}</a></li>
                        <li class="mb-1"><a href="{{ route('about') }}">{{ $menu_about ?? 'Tentang Kami' }}</a></li>
                        <li class="mb-1"><a href="{{ route('contact') }}">{{ $menu_contact ?? 'Kontak' }}</a></li>
                        <li class="mb-1"><a href="{{ route('articles') }}">Berita</a></li>
                        <li class="mb-1"><a href="{{ route('chat') }}">Chat AI</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h6>Tipe Properti</h6>
                    <ul class="list-unstyled">
                        <li class="mb-1"><a href="{{ route('project') }}?type=rumah">Rumah</a></li>
                        <li class="mb-1"><a href="{{ route('project') }}?type=apartemen">Apartemen</a></li>
                        <li class="mb-1"><a href="{{ route('project') }}?type=komersial">Komersial</a></li>
                        <li class="mb-1"><a href="{{ route('project') }}?type=tanah">Tanah</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>Kontak</h6>
                    @php $address = \App\Models\Setting::get('contact_address'); $phone = \App\Models\Setting::get('contact_phone'); $email = \App\Models\Setting::get('contact_email'); @endphp
                    @if($address)<p class="mb-2"><i class="bi bi-geo-alt me-2 text-gold"></i>{{ $address }}</p>@endif
                    @if($phone)<p class="mb-2"><i class="bi bi-telephone me-2 text-gold"></i>{{ $phone }}</p>@endif
                    @if($email)<p class="mb-2"><i class="bi bi-envelope me-2 text-gold"></i>{{ $email }}</p>@endif
                </div>
            </div>
            <hr class="footer-divider my-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <p class="mb-0">&copy; {{ date('Y') }} Midland Properti. All rights reserved.</p>
                <p class="mb-0">Powered by <span class="text-gold">Midland Properti</span></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    {{-- AI Chat Widget (hidden on /chat page itself) --}}
    @unless(request()->routeIs('chat'))
        @include('components.chat-widget')
    @endunless
</body>

</html>