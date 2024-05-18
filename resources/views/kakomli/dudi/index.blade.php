@extends('layouts.nav-kakomli')

@section('content')
<title>DuDi</title>
    <div class="card px-3 mb-4 flex-md-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Data-data Dudi</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex justify-content-center my-3">
            <form method="get" class="form-inline d-flex flex-row gap-1">
                <input class="form-control mr-sm-2 py-0" type="search" name="query" placeholder="Search"
                    aria-label="Search" value="{{ request('query') }}">
                <button class="btn btn-outline-primary py-0 my-sm-0" type="submit"><i
                        class="mdi mdi-magnify fs-4"></i></button>
            </form>
        </div>
        <div class="text-end">
            <a href="{{ route('dudi.create') }}" class="btn btn-outline-primary">Tambah Dudi</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Pemimpin Dudi</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dudi as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->pemimpin }}</td>
                                <td>{!! $data->no_telp ? "<a href='https://api.whatsapp.com/send?phone=$data->no_telp' target='_blank'>$data->no_telp</a>" : '<p>tidak ada no telp</p>' !!}</td>
                                <td style="white-space: initial">{{ $data->alamat }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('dudi.show', $data->id) }}" class="btn btn-primary px-2 py-1"><i
                                            class="link-icon" width="15" data-feather="file-text"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="mt-3 mb-3 text-center fw-bold">Tidak ada data dudi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 align-items-center">
                {{ $dudi->links('pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
