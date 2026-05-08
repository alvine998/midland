@extends('layouts.admin')
@section('title', 'Kelola Proyek')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <div class="page-title">Kelola Proyek</div>
        <div class="page-subtitle">Daftar semua proyek properti · Seret baris untuk mengubah urutan tampilan</div>
    </div>
    <div class="d-flex gap-2">
        <span id="reorder-badge" class="badge bg-warning text-dark d-none align-items-center gap-1" style="font-size:.78rem;padding:6px 10px">
            <i class="bi bi-arrow-up-down"></i> Mode Urutkan — seret baris
        </span>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Tambah Proyek
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($projects->count())
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-3 py-3" style="width:36px"></th>
                        <th class="py-3">#</th>
                        <th>Proyek</th>
                        <th>Lokasi</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Unggulan</th>
                        <th class="text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sortable-projects">
                    @foreach($projects as $i => $project)
                    <tr data-id="{{ $project->id }}" style="cursor:default">
                        <td class="px-3 text-center">
                            <span class="drag-handle text-muted" style="cursor:grab;font-size:1.1rem" title="Seret untuk mengubah urutan">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                        </td>
                        <td class="text-muted small row-number">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" style="width:45px;height:45px;object-fit:cover;border-radius:6px" alt="">
                                @else
                                    <div style="width:45px;height:45px;background:rgba(26,92,58,0.08);border-radius:6px;display:flex;align-items:center;justify-content:center">
                                        <i class="bi bi-building" style="color:var(--primary)"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-medium" style="color:var(--primary)">{{ $project->title }}</div>
                                    <div class="text-muted" style="font-size:0.78rem">{{ $project->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted small">{{ $project->location ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ ucfirst($project->type ?? '-') }}</span></td>
                        <td class="fw-medium" style="color:var(--gold)">{{ $project->price ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $project->status === 'available' ? 'bg-success' : ($project->status === 'upcoming' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ $project->status === 'available' ? 'Tersedia' : ($project->status === 'upcoming' ? 'Segera' : 'Terjual') }}
                            </span>
                        </td>
                        <td>
                            @if($project->featured)
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.properties.index', $project->slug) }}" class="btn btn-sm btn-outline-info me-1" title="Kelola Properti">
                                <i class="bi bi-houses"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus proyek ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-buildings text-muted" style="font-size:3rem;opacity:0.3"></i>
                <p class="text-muted mt-2">Belum ada proyek. <a href="{{ route('admin.projects.create') }}">Tambah sekarang</a></p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const tbody   = document.getElementById('sortable-projects');
    const badge   = document.getElementById('reorder-badge');
    const CSRF    = '{{ csrf_token() }}';
    const REORDER = '{{ route("admin.projects.reorder") }}';

    if (!tbody) return;

    badge.classList.remove('d-none');
    badge.classList.add('d-flex');

    Sortable.create(tbody, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'table-warning',
        onEnd: function () {
            // Re-number the # column
            tbody.querySelectorAll('tr').forEach((tr, i) => {
                tr.querySelector('.row-number').textContent = i + 1;
            });

            // Collect ordered IDs
            const ids = Array.from(tbody.querySelectorAll('tr[data-id]'))
                             .map(tr => tr.dataset.id);

            fetch(REORDER, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ids }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok) {
                    badge.innerHTML = '<i class="bi bi-check-circle-fill"></i> Urutan tersimpan';
                    badge.classList.remove('bg-warning', 'text-dark');
                    badge.classList.add('bg-success', 'text-white');
                    setTimeout(() => {
                        badge.innerHTML = '<i class="bi bi-arrow-up-down"></i> Mode Urutkan — seret baris';
                        badge.classList.remove('bg-success', 'text-white');
                        badge.classList.add('bg-warning', 'text-dark');
                    }, 2000);
                }
            })
            .catch(() => {
                badge.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> Gagal menyimpan';
                badge.classList.add('bg-danger', 'text-white');
            });
        }
    });
})();
</script>
@endpush
