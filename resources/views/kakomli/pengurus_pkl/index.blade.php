@extends('layouts.nav-kakomli')

@section('content')
    <div class="card px-3 mb-4 flex-md-row justify-content-between align-items-center">
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
        <div class="text-end">
            <a href="{{ route('pengurus-pkl.create') }}" class="btn btn-outline-primary">Tambah Pengurus PKL</a>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengurus as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td><img src="{{ asset($data->photo_guru) }}" alt="Photo pengurus PKL"></td>
                                <td style="white-space: initial;max-width: 200px">{{ $data->nama }} {{ $data->gelar ?? '' }}</td>
                                <td>{{ $data->email }}</td>
                                <td style="white-space: initial;max-width: 300px">{{ $data->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('pengurus-pkl.edit', $data->id) }}" class="btn btn-warning px-2 py-1"><i
                                            class="link-icon" width="15" data-feather="edit"></i></a>
                                    <form nameKakomli="{{ $data->nama }}" action="{{ route('pengurus-pkl.destroy', $data->id) }}" method="POST" class="delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger px-2 py-1"><i class="link-icon" width="15" data-feather="delete"></i></button>
                                    </form>
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
                {{ $pengurus->links('pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
        <script>
        if (document.querySelectorAll('.delete').length > 0) {
            document.querySelectorAll('.delete').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    var nameKakomli = form.getAttribute('nameKakomli');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Ingin menghapus pengurus PKL '" + nameKakomli + "'?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal",
                        background: 'var(--bs-body-bg)',
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        }
    </script>
@endsection