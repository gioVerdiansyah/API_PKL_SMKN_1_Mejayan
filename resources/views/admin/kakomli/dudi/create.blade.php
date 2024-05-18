@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Tambah dudi</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
    <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
    <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
    <div class="card p-4 mb-4 flex-row justify-content-md-between flex-column flex-md-row align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dudi.index') }}">Dudi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="text-end">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#uploadDataByExcel">Tambah Dudi
                by Excel</button>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-5">
            <h4 class="mt-2">Tambah Dudi</h4>
        </div>
        <form action="{{ route('admin.dudi.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="nama" class="form-label">Nama Dudi</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                placeholder="nama dudi" name="nama" id="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="pemimpin" class="form-label">Pemimpin Dudi</label>
                            <input type="text" class="form-control @error('pemimpin') is-invalid @enderror"
                                placeholder="Pemimpin dudi / manager dudi" name="pemimpin" id="pemimpin"
                                value="{{ old('pemimpin') }}">
                            @error('pemimpin')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="no_telp" class="form-label">Nomor Telepon (62xxx)</label>
                            <input type="tel" class="form-control @error('no_telp') is-invalid @enderror"
                                placeholder="Nomor telephone dudi" name="no_telp" id="no_telp"
                                value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email dudi" name="email" id="email" value="{{ old('email') }}">
                            @error('email')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="jurusan_id" class="form-label">Jurusan</label>

                            <select name="jurusan_id" id="jurusan_id" class="form-select">
                                <option selected disabled>Pilih Jurusan</option>
                                @foreach ($jurusans as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jurusan_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="koordinat" class="form-label">Koordinat</label>
                            <input type="text" class="form-control @error('koordinat') is-invalid @enderror"
                                placeholder="Koordinat lokasi dudi Ex: -7.900044393286019, 112.6069118963316"
                                name="koordinat" id="koordinat" value="{{ old('koordinat') }}">
                            @error('koordinat')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="radius" class="form-label">Radius</label>
                            <input type="number" class="form-control @error('radius') is-invalid @enderror"
                                placeholder="Radius tempat dudi" name="radius" id="radius"
                                value="{{ old('radius') }}">
                            @error('radius')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                placeholder="Alamat dudi" name="alamat" id="alamat" value="{{ old('alamat') }}">
                            @error('alamat')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md12 mt-5 text-start">
                <button type="submit" class="btn btn-primary profile-button">Tambah Dudi</button>
            </div>
        </form>
        <!-- Modal -->
        <div class="modal fade" id="uploadDataByExcel" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="uploadDataByExcelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadDataByExcelLabel">Export data dudi by Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <div>
                                <p class="text-bold">*Note</p>
                                <ul>
                                    <li>id tidak usah di isi</li>
                                    <li>jurusan_id harus di isi dengan singkatan juruan, misal RPL</li>
                                    <li>koordinat harus ada koma sebagai misal latitude dan longitude</li>
                                    <li>created_at tidak usah di isi</li>
                                    <li>updated_at tidak usah di isi</li>
                                </ul>
                            </div>
                            <a href="{{ route('admin.dudi.download_list_table') }}" type="button"
                                class="btn btn-primary">download list kolom</a>
                            <form action="{{ route('admin.dudi.import_data') }}" method="POST"
                                enctype="multipart/form-data" id="upload-form">
                                @csrf

                                <div class="input-group pt-3">
                                    <input type="file" class="form-control" name="file_excel" id="inputGroupFile02">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                @error('file_excel')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="$('#upload-form').submit()" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#jurusan_id').select2();
        });
    </script>
@endsection
