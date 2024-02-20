@extends('layouts.nav-kakomli')

@section('content')
<title>Kelompok Siswa PKL</title>
    <div class="card px-3 mb-4 flex-md-row justify-content-between align-items-center py-3 py-md-0">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Data-data Kelompok Siswa PKL</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <div class="d-flex justify-content-center my-3">
                <form method="get" class="form-inline d-flex flex-row gap-1">
                    <input class="form-control mr-sm-2 py-0" type="search" name="query" placeholder="Search"
                        aria-label="Search" value="{{ request('query') }}">
                    <button class="btn btn-outline-primary py-0 my-sm-0" type="submit"><i
                            class="mdi mdi-magnify fs-4"></i></button>
                </form>
            </div>
        </div>
        <div class="text-end">
            <a href="{{ route('kelompok-siswa.create') }}" class="btn btn-outline-primary">Tambah Kelompok</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelompok</th>
                            <th>DuDi</th>
                            <th>Pengurus/Pembimbing</th>
                            <th>Banyak Anggota</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelompok as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td style="white-space: initial">{{ $data->nama_kelompok }}</td>
                                <td>{{ $data->dudi->nama }}</td>
                                <td>{{ $data->guru->nama }}</td>
                                <td>{{ count($data->anggota) }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('kelompok-siswa.show', $data->id) }}" class="btn btn-primary px-2 py-1"><i
                                            class="link-icon" width="15" data-feather="file-text"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="mt-3 mb-3 text-center fw-bold">Tidak ada data...</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 align-items-center">
                {{ $kelompok->links('pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
