@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User</h1>
</div>

<form method="POST" action="{{ route('admin-users-edit', ['nrp' => $data['nrp']]) }}">
    @csrf
    <div class="mb-3">
      <label for="nrp" class="form-label">NRP</label>
      <input type="text" class="form-control @error('nrp') is-invalid @enderror"
      id="nrp" name="nrp" placeholder="Contoh: 2272037" required value="{{ old('nrp', $data['nrp']) }}" readonly>
      @error('nrp')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Nama</label>
      <input type="text" class="form-control @error('nama') is-invalid @enderror"
      id="nama" name="nama" placeholder="Contoh: Budi Santoso" required value="{{ old('nama', $data['nama']) }}">
      @error('nama')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control @error('email') is-invalid @enderror"
      id="email" name="email" placeholder="Contoh: budi@test.com" required value="{{ old('email', $data['email']) }}">
      @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="status" class="form-label">Status Mahasiswa</label>
      <input type="text" class="form-control @error('status') is-invalid @enderror"
      id="status" name="status" placeholder="Contoh: budi@test.com" required value="{{ old('status', $data['status']) }}">
      @error('status')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="role_id" class="form-label">Role</label>
      <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" id="role_id" required>
          @foreach ($roles as $role)
            @if ($data['role_id'] == $role['id'])
              <option value={{ $role['id'] }} selected>{{ $role['nama_role'] }}</option>
            @else
              <option value={{ $role['id'] }}>{{ $role['nama_role'] }}</option>
            @endif
          @endforeach
      </select>
      @error('role_id')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
    </div>
    <div class="mb-3">
        <label for="program_studi_id" class="form-label">Prodi</label>
        <select name="program_studi_id" class="form-select @error('program_studi_id') is-invalid @enderror" id="program_studi_id" required>
            @foreach ($prodis as $prodi)
                <option value={{ $prodi['id'] }}>{{ $prodi['kode'] }} - {{ $prodi['nama'] }}</option>
            @endforeach
        </select>
        @error('program_studi_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3 d-none" id="passwordDiv">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control @error('password') is-invalid @enderror"
      id="password" name="password" placeholder="Enter new password" value="{{ old('password', $data['password']) }}">
      @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection