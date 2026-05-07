<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-medium">Nama <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $testimonial->name ?? '') }}" required placeholder="Contoh: Budi Santoso">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Jabatan / Asal</label>
            <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                   value="{{ old('position', $testimonial->position ?? '') }}" placeholder="Contoh: Konsumen Proyek Greenville">
            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Isi Testimoni <span class="text-danger">*</span></label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5"
                      placeholder="Tuliskan isi testimoni di sini…" required>{{ old('content', $testimonial->content ?? '') }}</textarea>
            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">Rating (1–5) <span class="text-danger">*</span></label>
                <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                            {{ $i }} Bintang
                        </option>
                    @endfor
                </select>
                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control"
                       value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0">
                <div class="form-text">Angka kecil tampil lebih awal.</div>
            </div>
            <div class="col-md-4 d-flex align-items-end pb-1">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-medium" for="is_active">Tampilkan</label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-medium">Foto (opsional)</label>
            @if(isset($testimonial) && $testimonial->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="Foto" class="rounded-circle" style="width:80px;height:80px;object-fit:cover">
                </div>
            @endif
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
            <div class="form-text">Maks. 2MB. Disarankan foto persegi (1:1).</div>
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
