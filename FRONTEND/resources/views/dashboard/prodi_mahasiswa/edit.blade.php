@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User</h1>
</div>

<form method="POST" action="/dashboard/prodi_mahasiswa/{{ $user->id }}">
    @method('put')
    @csrf
    <div class="mb-3">
      <label for="nrp" class="form-label">NRP</label>
      <input type="text" class="form-control @error('nrp') is-invalid @enderror"
      id="nrp" name="nrp" placeholder="Contoh: 2272037" required value="{{ old('nrp', $user->nrp) }}">
      @error('nrp')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror"
      id="name" name="name" placeholder="Contoh: Budi Santoso" required value="{{ old('name', $user->name) }}">
      @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control @error('email') is-invalid @enderror"
      id="email" name="email" placeholder="Contoh: budi@test.com" required value="{{ old('email', $user->email) }}">
      @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection