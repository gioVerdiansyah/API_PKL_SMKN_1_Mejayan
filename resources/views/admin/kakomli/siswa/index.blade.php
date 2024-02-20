@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Siswa</title>
    <div class="card px-3 mb-4 flex-md-row justify-content-between align-items-center py-3 py-md-0">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Data-data siswa</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-md-center">
            <div class="col-md-6 col-12 me-3 col-lg-4 pk-0">
                <select name="jurusan" class="form-select" id="jurusan">
                    <option selected>Semua</option>
                    @foreach ($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>
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
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-outline-primary">Tambah Siswa</a>
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
                            <th>Kelas</th>
                            <th>NIS</th>
                            <th>Jenis kelamin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td style="white-space: initial">{{ $data->name }}</td>
                                <td>{{ $data->kelas->kelas }}</td>
                                <td>{{ $data->nis }}</td>
                                <td>{{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.siswa.show', $data->id) }}" class="btn btn-primary px-2 py-1"><i
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
                {{ $siswa->links('pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
    <script>
        document.getElementById('jurusan').addEventListener('change', function() {
            var selectedCategoryId = this.value;
            var currentUrl = window.location.href;
            var newUrl;
            if (selectedCategoryId === "Semua") {
                newUrl = currentUrl.replace(/jurusan=[^&]*/, '');
            } else {
                var ctParam = 'jurusan=' + selectedCategoryId;
                if (currentUrl.includes('jurusan=')) {
                    newUrl = currentUrl.replace(/jurusan=[^&]*/, ctParam);
                } else {
                    newUrl = currentUrl + (currentUrl.includes('?') ? '&' : '?') + ctParam;
                }
            }
            window.location.href = newUrl;
        });
    </script>
@endsection
