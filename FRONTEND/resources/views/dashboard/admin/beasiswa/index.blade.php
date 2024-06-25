@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Beasiswa</h1>
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
    <a href="{{ url('/dashboard/admin/beasiswa/create') }}" class="btn btn-primary mb-3">Tambah Beasiswa</a>
    <table class="table table-responsive table-bordered">
        <thead class="table-dark">
          <tr>
              <th scope="col" class="text-center w-1">No</th>
              <th scope="col">Jenis</th>
              <th scope="col">Nama Beasiswa</th>
              <th scope="col">Periode</th>
              <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($data as $beasiswa)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $beasiswa['jenis'] ?? 'N/A' }}</td>
                <td>{{ $beasiswa['nama'] ?? 'N/A' }}</td>
                <td>{{ $beasiswa['periode']['tahun'] ?? 'N/A' }}</td>
                <td>
                    <a href="{{ url("/dashboard/admin/beasiswa/{$beasiswa['id']}/edit") }}" class="badge bg-success"><span data-feather="edit"></span></a>
                    <form action="{{ url("/dashboard/admin/beasiswa/{$beasiswa['id']}") }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus beasiswa ini?')"><span data-feather="x-circle"></span></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No beasiswa found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
