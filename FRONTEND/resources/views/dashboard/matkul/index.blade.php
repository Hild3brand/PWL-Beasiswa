@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Mata Kuliah S1 - {{ auth()->user()->prodi->name }}</h1>
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
    <a href="/dashboard/matkul/create" class="btn btn-primary mb-3">Tambah Mata Kuliah</a>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Kode Mata Kuliah</th>
          <th scope="col">Nama Mata Kuliah</th>
          <th scope="col">SKS</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($matkuls as $matkul)
          @if ( $matkul->prodis_id == auth()->user()->prodi_id )
            <tr>
              <td>{{ $matkul->kode }}</td>
              <td>{{ $matkul->nama }}</td>
              <td>{{ $matkul->sks }}</td>
              <td>
                <a href="/dashboard/matkul/{{ $matkul->id }}/edit" class="badge bg-success"><span data-feather="edit"></span></a>
                <form action="/dashboard/matkul/{{ $matkul->id }}" method="POST" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus Mata Kuliah ini?')"><span data-feather="x-circle"></span></button>
                </form>
              </td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>

@endsection