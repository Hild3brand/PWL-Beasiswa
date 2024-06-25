@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Program Studi</h1>
</div>

<form method="POST" action="/dashboard/admin/prodi">
    @csrf
    <div class="mb-3">

      <label for="fakultas_id" class="form-label">Fakultas</label>
      <select class="form-control @error('fakultas_id') is-invalid @enderror" id="fakultas_id" name="fakultas_id" required>
          <option value="">Pilih Fakultas</option>
          @foreach($fakultas as $f)
              <option value="{{ $f['id'] }}">{{ $f['kode'] }} - {{ $f['nama'] }}</option>
          @endforeach
      </select>

      @error('fakultas_id')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="kode" class="form-label">Kode Program Studi</label>

      <input type="text" class="form-control @error('kode') is-invalid @enderror"

      id="kode" name="kode" placeholder="1 - 100" required>
      @error('kode')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror"
      id="name" name="name" placeholder="Contoh: Teknik Informatika" required>
      @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection

