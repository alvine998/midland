@extends('layouts.admin')
@section('title', 'Testimoni')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <div class="page-title">Testimoni</div>
        <div class="page-subtitle">Kelola ulasan dan testimoni pelanggan</div>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Testimoni
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
                    <th class="ps-4">Nama</th>
                    <th>Jabatan</th>
                    <th>Isi Testimoni</th>
                    <th>Rating</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-2">
                            @if($t->photo)
                                <img src="{{ asset('storage/' . $t->photo) }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover" alt="{{ $t->name }}">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;background:var(--primary);color:#fff;font-size:.85rem;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($t->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="fw-semibold">{{ $t->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted" style="font-size:.85rem">{{ $t->position ?: '—' }}</td>
                    <td style="max-width:260px;font-size:.85rem">{{ Str::limit($t->content, 80) }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $t->rating ? '-fill text-warning' : '' }}" style="font-size:.75rem"></i>
                        @endfor
                    </td>
                    <td>{{ $t->sort_order }}</td>
                    <td>
                        <span class="badge {{ $t->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $t->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus testimoni ini?')">
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
                        <i class="bi bi-chat-quote" style="font-size:2.5rem;display:block;opacity:.3;margin-bottom:.5rem"></i>
                        Belum ada testimoni. <a href="{{ route('admin.testimonials.create') }}">Tambah sekarang</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($testimonials->hasPages())
    <div class="card-footer bg-transparent border-top-0 py-3 px-4">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>
@endsection
