@extends('layouts.admin')
@section('title', 'Edit Lowongan')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.careers.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <div class="page-title">Edit Lowongan</div>
        <div class="page-subtitle">Perbarui detail lowongan pekerjaan</div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.careers.update', $career) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.careers._form')
            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i>Perbarui Lowongan
                </button>
                <a href="{{ route('admin.careers.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
