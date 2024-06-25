@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Mata Kuliah</h1>
</div>

<form method="POST" action="/dashboard/matkul">
    @csrf
    <div class="mb-3">
      <label for="kode" class="form-label">Kode Program Studi</label>
      <input type="text" class="form-control @error('prodis_id') is-invalid @enderror"
      id="prodis_id" name="prodis_id" placeholder="{{auth()->user()->prodi_id }} - {{ auth()->user()->prodi->name }}" required value="{{auth()->user()->prodi_id }}" readonly>
      @error('prodis_id')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="kode" class="form-label">Kode Mata Kuliah</label>
      <input type="text" class="form-control @error('kode') is-invalid @enderror"
      id="kode" name="kode" placeholder="Contoh : MKU024" required>
      @error('kode')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Mata Kuliah</label>
      <input type="text" class="form-control @error('nama') is-invalid @enderror"
      id="nama" name="nama" placeholder="Contoh: Bahasa Inggris" required>
      @error('nama')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="sks" class="form-label">SKS</label>
      <input type="number" class="form-control @error('sks') is-invalid @enderror"
      id="sks" name="sks" placeholder="Contoh : 2-4 SKS" required>
      @error('sks')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div>
      <a href="/dashboard/matkul" class="btn btn-danger mb-3">Back</a>
      <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </div>
</form>
@endsection