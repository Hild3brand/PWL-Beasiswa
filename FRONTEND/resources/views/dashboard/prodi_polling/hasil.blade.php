@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Mahasiswa</h1>
    <a href="/dashboard/prodi_polling" class="btn btn-danger mb-3">Back</a>
</div>

<div class="table-responsive">
    <!-- <a href="/dashboard/matkul/create" class="btn btn-primary mb-3">Tambah Mata Kuliah</a> -->
    <table class="table table-bordered table-sm">
      <thead class="table-dark">
        <tr>
          <th scope="col">Program Studi</th>
          <th scope="col">Kode Mata Kuliah</th>
          <th scope="col">Nama Mata Kuliah</th>
          <th scope="col">SKS</th>
          <th scope="col">Jumlah Mahasiswa</th>
          <th scope="col">Detail Mahasiswa</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($matkuls as $matkul)
          @if ( $matkul->prodis_id == auth()->user()->prodi_id )
            <tr>
              <td>{{ $matkul->prodi->kode }} - {{ $matkul->prodi->name }}</td>
              <td>{{ $matkul->kode }}</td>
              <td>{{ $matkul->nama }}</td>
              <td>{{ $matkul->sks }} SKS</td>
              <td>
                {{ $matkul->polling()->where('polling_id', $pollid)->count() }} Mahasiswa
              </td>
              <td>
                <a href="/dashboard/prodi_polling/{{ $pollid }}/{{ $matkul->id }}/detail" class="badge bg-success" style="text-decoration:none;"><span data-feather="layout"></span> Mahasiswa</a>
              </td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>

@endsection