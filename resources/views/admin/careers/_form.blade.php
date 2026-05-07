<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-medium">Judul Posisi <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $career->title ?? '') }}" required placeholder="Contoh: Marketing Executive">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-medium">Departemen</label>
                <input type="text" name="department" class="form-control"
                       value="{{ old('department', $career->department ?? '') }}" placeholder="Contoh: Marketing">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium">Lokasi</label>
                <input type="text" name="location" class="form-control"
                       value="{{ old('location', $career->location ?? '') }}" placeholder="Contoh: Jakarta Selatan">
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-medium">Tipe Pekerjaan <span class="text-danger">*</span></label>
                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="full-time"  {{ old('type', $career->type ?? '') === 'full-time'  ? 'selected' : '' }}>Full Time</option>
                    <option value="part-time"  {{ old('type', $career->type ?? '') === 'part-time'  ? 'selected' : '' }}>Part Time</option>
                    <option value="contract"   {{ old('type', $career->type ?? '') === 'contract'   ? 'selected' : '' }}>Kontrak</option>
                    <option value="internship" {{ old('type', $career->type ?? '') === 'internship' ? 'selected' : '' }}>Magang</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Batas Lamaran</label>
                <input type="date" name="deadline" class="form-control"
                       value="{{ old('deadline', isset($career) && $career->deadline ? $career->deadline->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium">Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control"
                       value="{{ old('sort_order', $career->sort_order ?? 0) }}" min="0">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Deskripsi Pekerjaan</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5"
                      placeholder="Jelaskan tanggung jawab dan detail pekerjaan…">{{ old('description', $career->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Persyaratan</label>
            <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="5"
                      placeholder="Tuliskan persyaratan pelamar…">{{ old('requirements', $career->requirements ?? '') }}</textarea>
            @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <h6 class="fw-semibold mb-3" style="color:var(--primary)">Pengaturan</h6>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $career->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-medium" for="is_active">Tampilkan di Website</label>
            </div>
            <div class="form-text mt-1">Nonaktifkan untuk menyembunyikan lowongan dari publik.</div>
        </div>
    </div>
</div>
