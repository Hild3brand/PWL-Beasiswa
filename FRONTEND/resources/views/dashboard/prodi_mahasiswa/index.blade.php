@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Users</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive">
    <table class="table table-responsive table-bordered">
      <thead class="table-dark">
        <tr>
          <th scope="col">NRP</th>
          <th scope="col">Nama</th>
          <th scope="col">Role</th>
          <th scope="col">Program Studi</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
            @if ( $user->prodi->id == auth()->user()->prodi->id  and $user->role == 'Mahasiswa')
            <tr>
            <td>{{ $user->nrp }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->prodi->name }}</td>
            <td>
                <a href="/dashboard/prodi_mahasiswa/{{ $user->id }}/edit" class="badge bg-success"><span data-feather="edit"></span></a>
            </td>
            </tr>
            @endif
        @endforeach
      </tbody>
    </table>
  </div>

@endsection