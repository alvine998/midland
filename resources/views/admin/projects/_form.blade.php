<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-medium">Nama Proyek <span class="text-danger">*</span></label>
            <input type="text" name="title" id="project-title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $project->title ?? '') }}" required placeholder="Contoh: Green Valley Residence">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Slug URL</label>
            <div class="input-group">
                <span class="input-group-text text-muted" style="font-size:.82rem">/project/</span>
                <input type="text" name="slug" id="project-slug" class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $project->slug ?? '') }}" placeholder="green-valley-residence">
                <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()" title="Generate dari judul">
                    <i class="bi bi-arrow-repeat"></i>
                </button>
            </div>
            <div class="form-text">Hanya huruf kecil, angka, dan tanda minus. Kosongkan untuk generate otomatis dari judul.</div>
            @error('slug')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6"
                      placeholder="Deskripsi lengkap proyek...">{{ old('description', $project->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-medium">Nama PIC (Person In Charge)</label>
                <input type="text" name="pic_name" class="form-control @error('pic_name') is-invalid @enderror"
                       value="{{ old('pic_name', $project->pic_name ?? '') }}" placeholder="Nama marketing/agen">
                @error('pic_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">No. WhatsApp PIC</label>
                <input type="tel" name="pic_phone" class="form-control @error('pic_phone') is-invalid @enderror"
                       value="{{ old('pic_phone', $project->pic_phone ?? '') }}" placeholder="62812xxxxxxxx">
                <div class="form-text">Format: 62812xxxxxxxx (tanpa simbol)</div>
                @error('pic_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-medium">Lokasi</label>
                <input type="text" name="location" class="form-control"
                       value="{{ old('location', $project->location ?? '') }}" placeholder="Contoh: Jakarta Selatan">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Harga</label>
                <input type="text" name="price" class="form-control"
                       value="{{ old('price', $project->price ?? '') }}" placeholder="Contoh: Rp 500 Juta">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Tipe Properti</label>
                <select name="type" class="form-select">
                    <option value="">Pilih Tipe</option>
                    @foreach(['rumah' => 'Rumah', 'apartemen' => 'Apartemen', 'komersial' => 'Komersial', 'tanah' => 'Tanah', 'vila' => 'Vila'] as $val => $lbl)
                        <option value="{{ $val }}" {{ old('type', $project->type ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="available" {{ old('status', $project->status ?? 'available') === 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="upcoming"  {{ old('status', $project->status ?? '') === 'upcoming' ? 'selected' : '' }}>Segera Hadir</option>
                    <option value="sold"      {{ old('status', $project->status ?? '') === 'sold' ? 'selected' : '' }}>Terjual</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Urutan</label>
                <input type="number" name="sort_order" class="form-control"
                       value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-medium">Foto Proyek</label>
            @if(!empty($project->image))
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $project->image) }}" class="img-thumbnail w-100" style="height:150px;object-fit:cover" alt="">
                    <div class="form-text">Gambar utama saat ini. Upload baru untuk mengganti.</div>
                </div>
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                   accept="image/jpeg,image/jpg,image/png,image/webp">
            <div class="form-text">Foto utama. Format: JPEG, PNG, WEBP. Maks 3 MB.</div>
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Galeri Foto Proyek (Max 10)</label>
            @if(!empty($project->images) && is_array($project->images))
                <div class="mb-3">
                    <div class="row g-2">
                        @foreach($project->images as $img)
                        <div class="col-4 position-relative">
                            <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail w-100" style="height:80px;object-fit:cover" alt="">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeImage(this, '{{ $img }}')">×</button>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-text mt-2">Total: {{ count($project->images) }} foto</div>
                </div>
            @endif
            <input type="file" name="images[]" multiple class="form-control @error('images') is-invalid @enderror"
                   accept="image/jpeg,image/jpg,image/png,image/webp">
            <div class="form-text">Format: JPEG, PNG, WEBP. Maksimal 10 foto, masing-masing 5 MB.</div>
            @error('images')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            @error('images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                   {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label fw-medium" for="featured">Tampilkan sebagai Unggulan</label>
            <div class="form-text">Proyek unggulan ditampilkan di halaman utama.</div>
        </div>
    </div>
</div>

<script>
(function () {
    const titleInput = document.getElementById('project-title');
    const slugInput  = document.getElementById('project-slug');
    let userEditedSlug = slugInput.value.length > 0;

    function toSlug(str) {
        return str.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/[\s_]+/g, '-')
            .replace(/-+/g, '-');
    }

    window.generateSlug = function () {
        slugInput.value = toSlug(titleInput.value);
        userEditedSlug = true;
    };

    // Auto-generate slug from title only when the slug hasn't been manually set
    titleInput.addEventListener('input', function () {
        if (!userEditedSlug) {
            slugInput.value = toSlug(this.value);
        }
    });

    slugInput.addEventListener('input', function () {
        userEditedSlug = this.value.length > 0;
        // Sanitize on the fly
        const pos = this.selectionStart;
        this.value = toSlug(this.value);
        this.setSelectionRange(pos, pos);
    });
})();
</script>
