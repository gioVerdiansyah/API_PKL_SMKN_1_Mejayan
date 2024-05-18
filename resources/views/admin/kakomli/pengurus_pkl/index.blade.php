@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Pengurus PKL</title>
    <div class="card px-3 mb-4 flex-md-row justify-content-between align-items-center py-3 py-md-0">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Data-data Guru Pengurus PKL</li>
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
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Photo Profile</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengurus as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td><img src="{{ asset($data->photo_guru) }}" alt="Photo pengurus PKL"></td>
                                <td style="white-space: initial;max-width: 200px">{{ $data->nama }}</td>
                                <td><p><a href='mailto:{{ $data->email }}' target='_blank'>{{ $data->email }}</a></p></td>
                                <td style="white-space: initial;max-width: 300px">
                                    {{ $data->deskripsi ?? 'Tidak ada deskripsi' }}</td>
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
                {{ $pengurus->links('pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
