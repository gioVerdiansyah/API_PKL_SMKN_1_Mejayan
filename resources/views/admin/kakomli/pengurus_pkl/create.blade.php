@extends('layouts.nav-admin')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Tambah pengurus PKL PKL</title>
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <div class="card p-3 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('pengurus-pkl.index') }}">pengurus PKL</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="text-end">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#uploadDataByExcel">Tambah
                Pengurus
                PKL
                by Excel</button>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Tambah Pengurus PKL</h4>
        </div>
        <form action="{{ route('pengurus-pkl.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex flex-column align-items-center pb-2">
                <label for="potoProfile" class="image-hover">
                    <span class="edit-icon"></span>
                    <img id="profileImage" src="{{ asset('images/mobile/default_photo.png') }}" alt="Photo profile"
                        width="100">
                </label>
                <input type="file" name="photo_guru" id="potoProfile" class="d-none">
                @error('poto_profile')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <h6 class="mt-2">Photo profile pengurus PKL</h6>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="nama" class="form-label">Nama</label>

                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                placeholder="nama pengurus PKL" name="nama" id="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>

                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                placeholder="email" name="email" id="email" value="{{ old('email') }}">
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
                            <label for="gelar" class="form-label">Gelar</label>

                            <input type="text" class="form-control @error('gelar') is-invalid @enderror"
                                placeholder="gelar (opsional)" name="gelar" id="gelar" value="{{ old('gelar') }}">
                            @error('gelar')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password</label>

                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="password pengurus PKL" name="password" id="password">
                            @error('password')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="deskripsi" class="form-label">Deskripsi</label>

                        <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="deskripsi"
                            name="deskripsi" id="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div>
                                <p class="text-danger mt-2">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md12 mt-5 text-start">
                <button type="submit" class="btn btn-primary profile-button">Tambah pengurus PKL</button>
            </div>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="uploadDataByExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="uploadDataByExcelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadDataByExcelLabel">Export data pengurus PKL by Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <a href="{{ route('pengurus-pkl.download_list_table') }}" type="button"
                            class="btn btn-primary">download list kolom</a>
                        <form action="{{ route('pengurus-pkl.import_data') }}" method="POST"
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
    <script>
        document.getElementById('potoProfile').addEventListener('change', function(event) {
            const inputFile = event.target;
            const profileImage = document.getElementById('profileImage');

            if (inputFile.files && inputFile.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                };

                reader.readAsDataURL(inputFile.files[0]);
            }
        });
    </script>
@endsection
