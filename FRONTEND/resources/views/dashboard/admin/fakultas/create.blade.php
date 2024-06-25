@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Fakultas</h1>
</div>

<form method="POST" action="{{ route('admin-fakultas-store') }}">
    @csrf
    <div class="mb-3">
        <label for="kode" class="form-label">Kode Fakultas</label>
        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" placeholder="Contoh: 70" required>
        @error('kode')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Fakultas</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Contoh: Teknologi Informasi" required>
        @error('nama')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
