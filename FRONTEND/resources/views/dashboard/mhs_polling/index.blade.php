@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Polling Mata Kuliah</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Polling</th>
          <th scope="col">Tanggal Polling</th>
          <th scope="col">Status Polling</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($polls as $poll)
          @php
          // Cek apakah polling detail sudah ada untuk user ini dan polling tertentu
          $pollingExists = \App\Models\PollingDetail::where('polling_id', $poll->id)
                         ->where('users_id', auth()->user()->id)
                         ->exists();
          @endphp
          <tr>
            <td>{{ $poll->nama_polling }}</td>
            <td>{{ $poll->start_date }} - {{ $poll->end_date }}</td>
            @if ($poll->status_polling == 0)
              <td>Polling masih berlangsung</td>
              <td>
                @if ($pollingExists)
                  <span class="badge bg-secondary">Polling sudah diisi</span>
                @else
                  <a href="/dashboard/mhs_polling/{{ $poll->id }}/create" class="badge bg-success" style="text-decoration: none;">
                    <span data-feather="edit"></span> Tambah Polling
                  </a>
                @endif
              </td>
            @else
              <td>Polling sudah ditutup</td>
              <td>
                <span class="badge bg-danger" style="text-decoration: none;">
                  <span data-feather="x-square"></span> Polling Sudah Melewati Deadline
                </span>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection
