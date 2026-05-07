@extends('layouts.admin')
@section('title', 'Karir')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <div class="page-title">Karir</div>
        <div class="page-subtitle">Kelola lowongan pekerjaan yang ditampilkan di website</div>
    </div>
    <a href="{{ route('admin.careers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Lowongan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">Posisi</th>
                    <th>Departemen</th>
                    <th>Lokasi</th>
                    <th>Tipe</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($careers as $career)
                <tr>
                    <td class="ps-4 fw-semibold">{{ $career->title }}</td>
                    <td class="text-muted" style="font-size:.85rem">{{ $career->department ?: '—' }}</td>
                    <td class="text-muted" style="font-size:.85rem">
                        {{ $career->location ? '📍 '.$career->location : '—' }}
                    </td>
                    <td>
                        @php $typeColors = ['full-time'=>'primary','part-time'=>'info','contract'=>'warning','internship'=>'secondary']; @endphp
                        <span class="badge bg-{{ $typeColors[$career->type] ?? 'secondary' }} bg-opacity-10 text-{{ $typeColors[$career->type] ?? 'secondary' }}">
                            {{ $career->getTypeLabel() }}
                        </span>
                    </td>
                    <td style="font-size:.85rem">
                        @if($career->deadline)
                            <span class="{{ $career->deadline->isPast() ? 'text-danger' : 'text-muted' }}">
                                {{ $career->deadline->format('d M Y') }}
                                {{ $career->deadline->isPast() ? '(Berakhir)' : '' }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $career->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $career->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <a href="{{ route('admin.careers.edit', $career) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.careers.destroy', $career) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus lowongan ini?')">
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
                        <i class="bi bi-briefcase" style="font-size:2.5rem;display:block;opacity:.3;margin-bottom:.5rem"></i>
                        Belum ada lowongan. <a href="{{ route('admin.careers.create') }}">Tambah sekarang</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($careers->hasPages())
    <div class="card-footer bg-transparent border-top-0 py-3 px-4">
        {{ $careers->links() }}
    </div>
    @endif
</div>
@endsection
