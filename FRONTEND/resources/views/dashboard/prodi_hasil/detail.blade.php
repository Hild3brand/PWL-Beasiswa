@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Mahasiswa</h1>
    <a href="/dashboard/prodi_hasil" class="btn btn-danger mb-3">Back</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">NRP</th>
                <th scope="col">Nama</th>
                <th scope="col">Mata Kuliah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($polls as $polling)
                @if ($matkul == $polling->matkul->id)
                    <tr>
                        <td>{{ $polling->user->nrp }}</td>
                        <td>{{ $polling->user->name }}</td>
                        <td>{{ $polling->matkul->kode }} - {{ $polling->matkul->nama }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

@endsection
