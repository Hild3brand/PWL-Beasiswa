@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Mata Kuliah</h1>
</div>

<form method="POST" action="/dashboard/prodi_polling">
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
      <label for="nama_polling" class="form-label">Nama Polling</label>
      <input type="text" class="form-control @error('nama_polling') is-invalid @enderror"
      id="nama_polling" name="nama_polling" placeholder="Contoh : Polling Mata Kuliah Semester Antara 2024/2025" required>
      @error('nama_polling')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="row mb-3">
        <div class="col">
        <label for="start_date" class="form-label">Tanggal Mulai</label>
        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
        id="start_date" name="start_date" placeholder="Contoh: Bahasa Inggris" required>
        @error('start_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        </div>
        <div class="col">
        <label for="end_date" class="form-label">Tanggal Berakhir</label>
        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
        id="end_date" name="end_date" placeholder="Contoh: Bahasa Inggris" required>
        @error('end_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        </div>
    </div>
    <div>
      <a href="/dashboard/prodi_polling" class="btn btn-danger mb-3">Back</a>
      <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </div>
</form>
@endsection