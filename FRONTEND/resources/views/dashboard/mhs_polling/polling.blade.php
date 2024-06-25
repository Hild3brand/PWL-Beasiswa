@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pilih Mata Kuliah</h1>
</div>

<form method="POST" action="/dashboard/mhs_polling" id="matkul-form">
    @csrf
    <div class="mb-3">
      <label for="id" class="form-label">Polling</label><br>
      <input type="text" name="polling_nama" id="polling_nama" value="{{ $poll->nama_polling }}" placeholder="{{ $poll->nama_polling }}" readonly class="form-control @error('poll') is-invalid @enderror">
    </div>
    <div class="mb-3">
      <label for="id" class="form-label">Kode Polling</label><br>
      <input type="text" name="polling_id" id="polling_id" value="{{ $poll->id }}" placeholder="{{ $poll->nama_polling }}" readonly class="form-control @error('poll') is-invalid @enderror">
    </div>
    <div class="mb-3">
      <label for="id" class="form-label">Kode Program Studi</label><br>
        @foreach($matkuls as $mk)
          @if ($mk->prodi->id == auth()->user()->prodi->id)
            <input type="checkbox" name="mata_kuliah[]" value="{{ $mk->id }}" data-sks="{{ $mk->sks }}"> {{ $mk->kode }} - {{ $mk->nama }} ( {{ $mk->sks }} SKS )<br>
          @endif
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script src="/js/polling.js"></script>
@endsection