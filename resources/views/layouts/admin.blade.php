<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin - @yield('title', 'Dashboard') | Midland Properti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- jQuery & Summernote -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --primary: #1a5c3a;
            --primary-light: #2a8a52;
            --gold: #c9a84c;
            --sidebar-w: 260px;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; margin: 0; }

        /* Sidebar */
        .sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh; background: var(--primary); z-index: 100; display: flex; flex-direction: column; transition: transform 0.3s; overflow-y: auto; }
        .sidebar-brand { padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand a { font-size: 1.2rem; font-weight: 700; color: var(--gold); text-decoration: none; letter-spacing: 0.5px; }
        .sidebar-brand .badge { font-size: 0.6rem; }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-section { font-size: 0.68rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.4); padding: 0.75rem 1.25rem 0.25rem; }
        .sidebar .nav-link { color: rgba(255,255,255,0.7); padding: 0.65rem 1.25rem; display: flex; align-items: center; gap: 0.75rem; border-radius: 0; transition: all 0.2s; font-size: 0.9rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); }
        .sidebar .nav-link.active { background: rgba(201,168,76,0.2); color: var(--gold); border-left: 3px solid var(--gold); }
        .sidebar .nav-link i { width: 20px; text-align: center; font-size: 1rem; }

        /* Main */
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0.875rem 1.5rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-weight: 600; color: var(--primary); font-size: 1rem; }
        .content-area { padding: 1.5rem; }

        /* Cards */
        .stat-card { border: none; border-radius: 12px; padding: 1.5rem; }
        .stat-card .stat-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
        .stat-card .stat-number { font-size: 2rem; font-weight: 700; color: var(--primary); line-height: 1; }
        .stat-card .stat-label { font-size: 0.8rem; color: #64748b; font-weight: 500; margin-top: 0.25rem; }

        /* Table */
        .table th { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; background: #f8fafc; }
        .table td { vertical-align: middle; font-size: 0.9rem; }

        /* Breadcrumb */
        .page-title { font-size: 1.4rem; font-weight: 700; color: var(--primary); margin-bottom: 0.25rem; }
        .page-subtitle { font-size: 0.85rem; color: #64748b; }

        /* Alert */
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-building me-2"></i>Midland CMS
        </a>
        <div class="mt-1">
            <span class="badge bg-warning text-dark" style="font-size:0.6rem">Admin Panel</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="nav-section mt-2">Konten</div>
        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
            <i class="bi bi-file-text"></i> Halaman
        </a>
        <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i> Proyek
        </a>
        <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ request()->routeIs('admin.galleries*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Galeri
        </a>
        <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Berita
        </a>
        <a href="{{ route('admin.organizations.index') }}" class="nav-link {{ request()->routeIs('admin.organizations*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Organisasi
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
            <i class="bi bi-chat-quote"></i> Testimoni
        </a>
        <a href="{{ route('admin.careers.index') }}" class="nav-link {{ request()->routeIs('admin.careers*') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i> Karir
        </a>

        <div class="nav-section mt-2">Leads</div>
        <a href="{{ route('admin.leads.index') }}" class="nav-link {{ request()->routeIs('admin.leads*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> Leads Simulasi
            @php $leadsCount = \App\Models\Lead::whereDate('created_at', today())->count(); @endphp
            @if($leadsCount > 0)
                <span class="badge ms-auto" style="background:var(--gold);color:var(--primary)">{{ $leadsCount }}</span>
            @endif
        </a>

        <div class="nav-section mt-2">Pengaturan</div>
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Pengaturan
        </a>

        <div class="nav-section mt-2">Website</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-link">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Website
        </a>

        <div class="mt-3 px-3">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm w-100 text-start" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.7);border:none;padding:0.65rem 1rem;display:flex;align-items:center;gap:0.75rem">
                    <i class="bi bi-box-arrow-left" style="width:20px;text-align:center"></i> Keluar
                </button>
            </form>
        </div>
    </nav>
</aside>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')" style="background:none;border:none;font-size:1.3rem;color:var(--primary)">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <div style="width:32px;height:32px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-person-fill text-white" style="font-size:0.85rem"></i>
                </div>
                <span class="fw-medium d-none d-md-inline" style="font-size:0.9rem;color:var(--primary)">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js" integrity="sha384-TtWVJ+ZLDHxX/2c0bX1Z1dJoKfqN+qKo8kB93GyPv5CoBrJ1BjLFqtqhXEKl4VhQm" crossorigin="anonymous"></script>
@stack('scripts')
</body>
</html>
