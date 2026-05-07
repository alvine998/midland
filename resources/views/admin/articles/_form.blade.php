<div class="row g-4">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-medium">Judul Berita <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $article->title ?? '') }}" required placeholder="Contoh: Info Promo Properti Terbaru">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Ringkasan (Excerpt)</label>
            <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3"
                      placeholder="Ringkasan singkat berita (ditampilkan di listing)...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            <div class="form-text">Maksimal 500 karakter</div>
            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-medium">Konten Berita <span class="text-danger">*</span></label>
            <textarea name="content" id="content-editor" class="form-control @error('content') is-invalid @enderror" rows="10"
                      placeholder="Tuliskan konten berita lengkap di sini...">{{ old('content', $article->content ?? '') }}</textarea>
            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-medium">Penulis</label>
                <input type="text" name="author" class="form-control"
                       value="{{ old('author', $article->author ?? '') }}" placeholder="Nama penulis">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Tanggal Publikasi</label>
                <input type="date" name="published_at" class="form-control"
                       value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-medium">Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control"
                       value="{{ old('sort_order', $article->sort_order ?? 0) }}" min="0">
                <div class="form-text">Angka kecil tampil lebih awal.</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label fw-medium">Gambar Berita</label>
            @if(isset($article) && $article->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $article->image) }}" class="img-thumbnail w-100" style="height:200px;object-fit:cover" alt="">
                    <div class="form-text mt-2">Gambar saat ini. Upload baru untuk mengganti.</div>
                </div>
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                   accept="image/jpeg,image/jpg,image/png,image/webp">
            <div class="form-text">Format: JPEG, PNG, WEBP. Maks 5 MB.</div>
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
