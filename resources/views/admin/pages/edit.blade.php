@extends('layouts.admin')
@section('title', 'Edit Halaman: ' . ucfirst($slug))

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <div class="page-title">Edit Halaman: {{ $slug === 'about' ? 'Tentang Kami' : ucfirst($slug) }}</div>
        <div class="page-subtitle">Kelola konten yang ditampilkan di halaman {{ $slug === 'about' ? 'Tentang Kami' : ucfirst($slug) }}</div>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('admin.pages.update', $slug) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

{{-- ── HERO / BANNER ────────────────────────────────── --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <h6 class="mb-0 fw-semibold" style="color:var(--primary)">
            <i class="bi bi-image me-2"></i>Header / Banner Halaman
        </h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-medium">Judul Header</label>
                <input type="text" name="hero_title" class="form-control"
                       value="{{ old('hero_title', $page->hero_title ?? '') }}"
                       placeholder="{{ $slug === 'about' ? 'Tentang Kami' : 'Judul halaman' }}">
                <div class="form-text">Judul besar yang tampil di bagian atas halaman.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Subjudul Header</label>
                <input type="text" name="hero_subtitle" class="form-control"
                       value="{{ old('hero_subtitle', $page->hero_subtitle ?? '') }}"
                       placeholder="Teks pendamping di bawah judul">
            </div>
            <div class="col-12">
                <label class="form-label fw-medium">Gambar Hero / Banner</label>
                @if(!empty($page->hero_image))
                    <div class="mb-2 d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $page->hero_image) }}" class="img-thumbnail" style="height:80px;object-fit:cover" alt="Hero">
                        <span class="text-muted small">Gambar saat ini. Upload baru untuk mengganti.</span>
                    </div>
                @endif
                <input type="file" name="hero_image" class="form-control @error('hero_image') is-invalid @enderror"
                       accept="image/jpeg,image/jpg,image/png,image/webp">
                <div class="form-text">Format: JPEG, PNG, WEBP. Maks 3 MB.</div>
                @error('hero_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            @if($slug !== 'about')
            <div class="col-12">
                <label class="form-label fw-medium">Video Background URL <span class="text-muted">(opsional)</span></label>
                <input type="url" name="video_url" class="form-control"
                       value="{{ old('video_url', $page->video_url ?? '') }}"
                       placeholder="https://videos.pexels.com/...mp4">
                <div class="form-text">URL video MP4. Jika diisi, video diputar sebagai background hero. Kosongkan untuk gunakan gambar.</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── KONTEN UTAMA ─────────────────────────────────── --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <h6 class="mb-0 fw-semibold" style="color:var(--primary)">
            <i class="bi bi-text-paragraph me-2"></i>Konten Utama
        </h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-12">
                <label class="form-label fw-medium">Judul Seksi</label>
                <input type="text" name="section_title" class="form-control"
                       value="{{ old('section_title', $page->section_title ?? '') }}"
                       placeholder="{{ $slug === 'about' ? 'Midland Properti' : 'Judul seksi konten' }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-medium">Deskripsi / Paragraf Utama</label>
                <textarea id="content-editor" name="content" rows="6"
                          class="form-control">{{ old('content', $page->content ?? '') }}</textarea>
                <div class="form-text">Teks ini tampil sebagai deskripsi utama di halaman {{ $slug === 'about' ? 'Tentang Kami' : ucfirst($slug) }}.</div>
            </div>
        </div>
    </div>
</div>

{{-- ── VISI & MISI (only for about) ───────────────────── --}}
@if($slug === 'about')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3 px-4">
        <h6 class="mb-0 fw-semibold" style="color:var(--primary)">
            <i class="bi bi-eye me-2"></i>Visi &amp; Misi
        </h6>
        <small class="text-muted">Ditampilkan di seksi "Komitmen Kami" halaman Tentang Kami.</small>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-12">
                <label class="form-label fw-medium">Visi</label>
                <textarea name="vision" class="form-control" rows="3"
                          placeholder="Menjadi agen properti terkemuka dan terpercaya di Indonesia...">{{ old('vision', $page->vision ?? '') }}</textarea>
                <div class="form-text">Pernyataan visi perusahaan.</div>
            </div>
            <div class="col-12">
                <label class="form-label fw-medium">Misi</label>
                <textarea name="mission" class="form-control" rows="5"
                          placeholder="Tulis setiap poin misi di baris baru, contoh:&#10;Menyediakan properti berkualitas tinggi di lokasi strategis.&#10;Memberikan pelayanan profesional dan transparan.">{{ old('mission', $page->mission ?? '') }}</textarea>
                <div class="form-text">Tulis setiap poin misi di baris terpisah — masing-masing akan tampil sebagai satu butir di halaman.</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── SIAPA KAMI — KEUNGGULAN POIN (only for about) ─── --}}
@if($slug === 'about')
@php
$defaultFeatures = [
    ['icon' => 'shield-check', 'title' => 'Terpercaya',        'desc' => 'Agen properti berlisensi dengan rekam jejak yang terbukti.'],
    ['icon' => 'graph-up',     'title' => 'Berpengalaman',     'desc' => 'Lebih dari 15 tahun pengalaman di industri properti Indonesia.'],
    ['icon' => 'people',       'title' => 'Profesional',       'desc' => 'Tim agen profesional yang siap melayani kebutuhan Anda.'],
    ['icon' => 'heart',        'title' => 'Berorientasi Klien','desc' => 'Kepuasan klien adalah prioritas utama kami.'],
];
$features = old('features', $page->features ?? $defaultFeatures);
@endphp
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
        <div>
            <h6 class="mb-0 fw-semibold" style="color:var(--primary)">
                <i class="bi bi-grid-1x2 me-2"></i>Poin Keunggulan "Siapa Kami"
            </h6>
            <small class="text-muted">Empat kartu yang tampil di sebelah kanan teks Tentang Kami.</small>
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary" id="add-feature-btn">
            <i class="bi bi-plus-circle me-1"></i>Tambah Poin
        </button>
    </div>
    <div class="card-body p-4">
        <div id="features-container">
            @foreach($features as $i => $feat)
            <div class="feature-row card border mb-3" data-index="{{ $i }}">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-medium text-muted small">Poin {{ $i + 1 }}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-feature-btn" title="Hapus poin ini">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-medium">Judul</label>
                            <input type="text" name="features[{{ $i }}][title]" class="form-control form-control-sm"
                                   value="{{ $feat['title'] ?? '' }}" placeholder="Contoh: Terpercaya" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-medium">Deskripsi</label>
                            <input type="text" name="features[{{ $i }}][desc]" class="form-control form-control-sm"
                                   value="{{ $feat['desc'] ?? '' }}" placeholder="Kalimat pendek penjelasan">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-medium">
                                Ikon Bootstrap
                                <a href="https://icons.getbootstrap.com" target="_blank" class="ms-1 text-muted" title="Daftar ikon">
                                    <i class="bi bi-box-arrow-up-right" style="font-size:.7rem"></i>
                                </a>
                            </label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-{{ $feat['icon'] ?? 'star' }}" id="icon-preview-{{ $i }}"></i></span>
                                <input type="text" name="features[{{ $i }}][icon]" class="form-control form-control-sm icon-input"
                                       value="{{ $feat['icon'] ?? 'star' }}" placeholder="shield-check" data-index="{{ $i }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>Nama ikon dari <a href="https://icons.getbootstrap.com" target="_blank">Bootstrap Icons</a> — contoh: <code>shield-check</code>, <code>people</code>, <code>heart</code>, <code>graph-up</code>.</p>
    </div>
</div>
@endif

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-check2 me-2"></i>Simpan Konten
    </button>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>

</form>
@endsection

@push('scripts')
<script>
$('#content-editor').summernote({
    height: 220,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para',  ['ul', 'ol', 'paragraph']],
        ['insert',['link']],
        ['view',  ['fullscreen', 'codeview']],
    ],
    placeholder: 'Masukkan deskripsi / konten halaman...',
});

// Live icon preview
document.addEventListener('input', function(e) {
    if (!e.target.classList.contains('icon-input')) return;
    const idx = e.target.dataset.index;
    const preview = document.getElementById('icon-preview-' + idx);
    if (preview) {
        preview.className = 'bi bi-' + (e.target.value.trim() || 'star');
    }
});

// Remove a feature row
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.remove-feature-btn');
    if (!btn) return;
    const row = btn.closest('.feature-row');
    row.remove();
    reindexFeatures();
});

// Add a new feature row
document.getElementById('add-feature-btn')?.addEventListener('click', function() {
    const container = document.getElementById('features-container');
    const idx = container.querySelectorAll('.feature-row').length;
    const html = `
    <div class="feature-row card border mb-3" data-index="${idx}">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="fw-medium text-muted small">Poin ${idx + 1}</span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-feature-btn" title="Hapus poin ini">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-medium">Judul</label>
                    <input type="text" name="features[${idx}][title]" class="form-control form-control-sm" placeholder="Contoh: Inovatif" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label small fw-medium">Deskripsi</label>
                    <input type="text" name="features[${idx}][desc]" class="form-control form-control-sm" placeholder="Kalimat pendek penjelasan">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Ikon Bootstrap</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-star" id="icon-preview-${idx}"></i></span>
                        <input type="text" name="features[${idx}][icon]" class="form-control form-control-sm icon-input"
                               value="star" placeholder="shield-check" data-index="${idx}">
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
});

function reindexFeatures() {
    document.querySelectorAll('#features-container .feature-row').forEach((row, i) => {
        row.dataset.index = i;
        row.querySelector('.fw-medium.text-muted.small').textContent = 'Poin ' + (i + 1);
        row.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/features\[\d+\]/, `features[${i}]`);
        });
        row.querySelectorAll('.icon-input').forEach(el => el.dataset.index = i);
        const preview = row.querySelector('[id^="icon-preview-"]');
        if (preview) preview.id = 'icon-preview-' + i;
    });
}
</script>
@endpush
