@extends('layouts.admin')
@section('title', 'Leads Simulasi')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <div class="page-title">Leads Simulasi Cicilan</div>
        <div class="page-subtitle">Daftar calon konsumen yang menggunakan fitur Simulasi Cicilan</div>
    </div>
    <span class="badge fs-6 px-3 py-2" style="background:var(--primary);color:#fff">
        {{ $leads->total() }} Total Lead
    </span>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau nomor telepon…" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary px-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Harga Simulasi</th>
                    <th>Tanggal</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                <tr>
                    <td class="ps-4 text-muted" style="font-size:.8rem">{{ $lead->id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $lead->name }}</div>
                    </td>
                    <td>
                        <a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->email }}</a>
                    </td>
                    <td>
                        @php $wa = preg_replace('/\D/', '', $lead->phone); @endphp
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="text-decoration-none">
                            <i class="bi bi-whatsapp text-success me-1"></i>{{ $lead->phone }}
                        </a>
                    </td>
                    <td>
                        @if($lead->price_input)
                            <span class="fw-semibold" style="color:var(--primary)">
                                Rp {{ number_format($lead->price_input, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:.85rem">{{ $lead->created_at->format('d M Y') }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $lead->created_at->format('H:i') }}</div>
                    </td>
                    <td class="pe-4 text-end">
                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST"
                              onsubmit="return confirm('Hapus lead ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size:2.5rem;display:block;opacity:.3;margin-bottom:.5rem"></i>
                        Belum ada leads yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($leads->hasPages())
    <div class="card-footer bg-transparent border-top-0 py-3 px-4">
        {{ $leads->links() }}
    </div>
    @endif
</div>
@endsection
