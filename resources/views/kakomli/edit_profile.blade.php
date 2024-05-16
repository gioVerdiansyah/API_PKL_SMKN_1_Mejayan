@extends('layouts.nav-kakomli')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <title>Edit Profile</title>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dudi.index') }}">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-5">
            <h4 class="mt-2">Tambah Dudi</h4>
        </div>
        <form action="{{ route('kakomli.update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="d-flex flex-column align-items-center pb-2">
                <label for="potoProfile" class="image-hover">
                    <span class="edit-icon"></span>
                    <img id="profileImage" src="{{ asset($kakomli->photo_profile) }}" alt="Photo profile" width="100">
                </label>
                <input type="file" name="photo_profile" id="potoProfile" class="d-none">
                @error('poto_profile')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <h6 class="mt-2">Photo profile siswa</h6>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="nama" class="form-label">Nama</label>

                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                placeholder="nama siswa" name="nama" id="nama"
                                value="{{ old('nama', $kakomli->nama) }}">
                            @error('nama')
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
                                placeholder="password baru Anda" name="password" id="password">
                            @error('password')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="no_hp" class="form-label">No HP</label>

                            <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                placeholder="no_hp Anda" name="no_hp" id="no_hp"
                                value="{{ old('no_hp', $guru->no_hp) }}">
                            @error('no_hp')
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
                            <label for="email" class="form-label">Email</label>

                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                placeholder="email Anda" name="email" id="email"
                                value="{{ old('email', $kakomli->email) }}">
                            @error('email')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="confirm_pass" class="form-label">Konfirmasi Password</label>

                            <input type="password" class="form-control @error('confirm_pass') is-invalid @enderror"
                                placeholder="Konfirmasi Password Anda" name="confirm_pass" id="confirm_pass">
                            @error('confirm_pass')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="confirm_pass" class="form-label">Deskripsi singkat Anda</label>

                            <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="deskripsi"
                                name="deskripsi" id="deskripsi" rows="5">{{ old('alamat', $guru->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-warning text-white">Update</button>
            </div>
        </form>
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
