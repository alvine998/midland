@extends('layouts.admin')
@section('title', 'Tambah Berita')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-chevron-left"></i> Kembali ke Berita
    </a>
    <h1 class="h3 mt-2">Tambah Berita Baru</h1>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.articles._form')
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Simpan Berita
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function initSummernote() {
    if (typeof $.fn.summernote !== 'undefined') {
        $('#content-editor').summernote({
            height: 400,
            minHeight: 300,
            maxHeight: 600,
            focus: false,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
        console.log('Summernote initialized successfully');
    } else {
        console.log('Summernote not available yet, retrying...');
        setTimeout(initSummernote, 100);
    }
}

$(document).ready(function() {
    setTimeout(initSummernote, 200);
});
</script>
@endpush
