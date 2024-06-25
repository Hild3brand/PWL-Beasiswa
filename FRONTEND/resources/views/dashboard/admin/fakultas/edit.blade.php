@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Fakultas</h1>
</div>


@if($fakultas)
    <form method="POST" action="/dashboard/admin/fakultas/{{ $fakultas['kode'] }}">
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="kode" class="form-label">Kode Fakultas</label>
            <input type="text" class="form-control @error('kode') is-invalid @enderror"
            id="kode" name="kode" placeholder="Contoh: 70" required value="{{ old('kode', $fakultas['kode']) }}" readonly>
            @error('kode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror"
            id="nama" name="nama" placeholder="Contoh: Teknologi Informasi" required value="{{ old('nama', $fakultas['nama']) }}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@else
    <div class="alert alert-danger" role="alert">
        Fakultas data not found.
    </div>
@endif
@endsection

