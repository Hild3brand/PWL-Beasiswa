@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Polling Mata Kuliah Program Studi S1 - {{ auth()->user()->prodi->name }}</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive">
    <a href="/dashboard/prodi_polling/create" class="btn btn-primary mb-3">Tambah Polling</a>
    <table class="table table-bordered table-sm">
      <thead class="table-dark">
        <tr>
          <th scope="col">Nama Polling</th>
          <th scope="col">Tanggal Polling</th>
          <th scope="col">Status Polling</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($polls as $poll)
        <tr>
          <td>{{ $poll->nama_polling }}</td>
          <td>{{ $poll->start_date }} - {{ $poll->end_date }}</td>
          @if ($poll->status_polling == 0)
          <td>Polling masih dibuka</td>
          @else
          <td>Polling sudah ditutup</td>
          @endif
          <td>
            <a href="/dashboard/prodi_polling/{{ $poll->id }}/show" class="badge bg-primary"><span data-feather="eye"></span></a>
            <a href="/dashboard/prodi_polling/{{ $poll->id }}/edit" class="badge bg-success"><span data-feather="edit"></span></a>
            <form action="/dashboard/prodi_polling/{{ $poll->id }}" method="POST" class="d-inline">
              @method('delete')
              @csrf
              <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"><span data-feather="x-circle"></span></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection