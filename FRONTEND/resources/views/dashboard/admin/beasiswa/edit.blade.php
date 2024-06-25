@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Beasiswa</h1>
</div>

<form method="POST" action="{{ url("/dashboard/admin/beasiswa/{$beasiswa['id']}") }}">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="jenis" class="form-label">Jenis Beasiswa</label>
        <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required value="{{ old('jenis', $beasiswa['jenis']) }}">
        @error('jenis')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Beasiswa</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required value="{{ old('nama', $beasiswa['nama']) }}">
        @error('nama')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="periode_id" class="form-label">Periode</label>
        <select class="form-select" id="periode_id" name="periode_id">
            @foreach ($periode as $p)
            <option value="{{ $p['id'] }}" {{ $p['id'] == $beasiswa['periode_id'] ? 'selected' : '' }}>{{ $p['tahun'] }}</option>
            @endforeach
        </select>
        @error('periode_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update Beasiswa</button>
</form>

@endsection
