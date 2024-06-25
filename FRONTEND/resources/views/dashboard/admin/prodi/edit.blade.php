@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Program Studi</h1>
</div>

<form method="POST" action="/dashboard/admin/prodi/{{ $prodi->id }}">
    @method('put')
    @csrf
    <div class="mb-3">
      <label for="fakultas_id">Fakultas</label>
      <select name="fakultas_id" class="form-select" disabled>
        @foreach ($fakultas as $faculty)
          @if (old('fakultas_id', $prodi->fakultas_id) == $faculty->id)
            <option value="{{ $faculty->id }}" selected>{{ $faculty->kode }} - {{ $faculty->nama }}</option>
          @else
            <option value="{{ $faculty->id }}">{{ $faculty->kode }} - {{ $faculty->nama }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label for="kode" class="form-label">Kode Program Studi</label>
      <input type="text" class="form-control @error('kode') is-invalid @enderror"
      id="kode" name="kode" placeholder="kode" required value="{{ old('id', $prodi->kode) }} ">
      @error('kode')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror"
      id="name" name="name" placeholder="Contoh: Budi Santoso" required value="{{ old('name', $prodi->name) }}">
      @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection