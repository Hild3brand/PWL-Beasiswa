@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Fakultas</h1>
</div>

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif

<div class="table-responsive">
    <a href="{{ url('/dashboard/admin/fakultas/create') }}" class="btn btn-primary mb-3">Tambah Fakultas</a>
    <table class="table table-responsive table-bordered">
        <thead class="table-dark">
          <tr>
              <th scope="col" class="text-center w-1">No</th>
              <th scope="col">Kode Fakultas</th>
              <th scope="col">Nama Fakultas</th>
              <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($data as $faculty)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $faculty['kode'] ?? 'N/A' }}</td>
                <td>{{ $faculty['nama'] ?? 'N/A' }}</td>
                <td>
                    <a href="{{ url("/dashboard/admin/fakultas/{$faculty['id']}/edit") }}" class="badge bg-success"><span data-feather="edit"></span></a>
                    <form action="{{ url("/dashboard/admin/fakultas/{$faculty['id']}") }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus Fakultas ini?')"><span data-feather="x-circle"></span></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No faculties found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
