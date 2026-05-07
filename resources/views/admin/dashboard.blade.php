@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <div class="page-title">Dashboard</div>
        <div class="page-subtitle">Selamat datang di CMS Midland Properti</div>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Website
    </a>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(26,92,58,0.1)">
                    <i class="bi bi-buildings" style="color:var(--primary)"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $stats['total_projects'] }}</div>
                    <div class="stat-label">Total Proyek</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(201,168,76,0.1)">
                    <i class="bi bi-star" style="color:var(--gold)"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $stats['featured'] }}</div>
                    <div class="stat-label">Proyek Unggulan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(34,197,94,0.1)">
                    <i class="bi bi-check-circle" style="color:#22c55e"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $stats['available'] }}</div>
                    <div class="stat-label">Properti Tersedia</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(99,102,241,0.1)">
                    <i class="bi bi-images" style="color:#6366f1"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $stats['gallery'] }}</div>
                    <div class="stat-label">Foto Galeri</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(201,168,76,0.1)">
                    <i class="bi bi-person-lines-fill" style="color:var(--gold)"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $stats['leads_total'] }}</div>
                    <div class="stat-label">
                        Leads Simulasi
                        @if($stats['leads_today'] > 0)
                            <span class="badge ms-1" style="background:var(--gold);color:var(--primary);font-size:.65rem">+{{ $stats['leads_today'] }} hari ini</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions + Guide -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3" style="color:var(--primary)"><i class="bi bi-lightning me-2 text-warning"></i>Aksi Cepat</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-outline-primary btn-sm text-start">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Proyek Baru
                    </a>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-outline-primary btn-sm text-start">
                        <i class="bi bi-image-fill me-2"></i>Upload Foto Galeri
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary btn-sm text-start">
                        <i class="bi bi-pencil me-2"></i>Edit Menu Navigasi
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-primary btn-sm text-start">
                        <i class="bi bi-file-text me-2"></i>Edit Konten Halaman
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3" style="color:var(--primary)"><i class="bi bi-info-circle me-2"></i>Panduan Penggunaan</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check2-circle text-success mt-1"></i>
                        <span>Gunakan menu <strong>Pengaturan</strong> untuk mengubah teks navigasi (Home, Project, Gallery, dll.)</span>
                    </li>
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check2-circle text-success mt-1"></i>
                        <span>Gunakan menu <strong>Halaman</strong> untuk mengedit konten tiap halaman (hero, deskripsi, dll.)</span>
                    </li>
                    <li class="mb-2 d-flex gap-2">
                        <i class="bi bi-check2-circle text-success mt-1"></i>
                        <span>Gunakan menu <strong>Proyek</strong> untuk menambah, mengedit, atau menghapus proyek properti.</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-check2-circle text-success mt-1"></i>
                        <span>Gunakan menu <strong>Galeri</strong> untuk mengelola foto-foto yang ditampilkan di halaman galeri.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leads -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4 d-flex align-items-center justify-content-between mb-0">
        <h6 class="fw-semibold mb-0" style="color:var(--primary)"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Leads Simulasi Terbaru</h6>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Harga Simulasi</th>
                    <th class="pe-4">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLeads as $lead)
                <tr>
                    <td class="ps-4 fw-semibold">{{ $lead->name }}</td>
                    <td><a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->email }}</a></td>
                    <td>
                        @php $wa = preg_replace('/\D/', '', $lead->phone); @endphp
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="text-decoration-none">
                            <i class="bi bi-whatsapp text-success me-1"></i>{{ $lead->phone }}
                        </a>
                    </td>
                    <td>
                        @if($lead->price_input)
                            <span style="color:var(--primary);font-weight:600">Rp {{ number_format($lead->price_input, 0, ',', '.') }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="pe-4 text-muted" style="font-size:.82rem">{{ $lead->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada leads.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
