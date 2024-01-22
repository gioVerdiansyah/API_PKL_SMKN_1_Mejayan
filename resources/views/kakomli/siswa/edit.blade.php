@extends('layouts.nav-kakomli')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Update siswa PKL</title>
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="text-end">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#uploadDataByExcel">Update Siswa
                PKL
                by Excel</button>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Update Siswa PKL</h4>
        </div>
        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="d-flex flex-column align-items-center pb-2">
                <label for="potoProfile" class="image-hover">
                    <span class="edit-icon"></span>
                    <img id="profileImage" src="{{ asset($siswa->photo_profile) }}" alt="Photo profile"
                        width="100">
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
                                placeholder="nama siswa" name="nama" id="nama" value="{{ old('nama', $siswa->name) }}">
                            @error('nama')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="nis" class="form-label">NIS</label>

                            <input type="text" class="form-control @error('nis') is-invalid @enderror" placeholder="NIS"
                                name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}">
                            @error('nis')
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
                                placeholder="password siswa" name="password" id="password">
                            @error('password')
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
                                placeholder="email" name="email" id="email" value="{{ old('email', $siswa->email) }}">
                            @error('email')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="no_telp" class="form-label">No Telp</label>

                            <input type="number" class="form-control" placeholder="no telp" name="no_telp" id="no_telp"
                                value="{{ old('no_telp',$siswa->no_hp) }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="no_hp_ortu" class="form-label">No HP ortu</label>

                            <input type="number" class="form-control" placeholder="no hp ortu" name="no_hp_ortu"
                                id="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="absen" class="form-label">Absen</label>

                            <input type="text" class="form-control @error('absen') is-invalid @enderror"
                                placeholder="absen" name="absen" id="absen" value="{{ old('absen', $siswa->absen) }}">
                            @error('absen')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="kelas" class="form-label">Kelas</label>

                            <select name="kelas" id="kelas" class="form-select">
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('kelas', $siswa->kelas_id) == $item->id ? 'selected' : '' }}>{{ $item->kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="jurusan" class="form-label">Jurusan</label>

                            <select name="jurusan" id="jurusan" class="form-select">
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jurusan', $siswa->jurusan_id) == $item->id ? 'selected' : '' }}>{{ $item->jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-2">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio" name="jenis_kelamin" id="jenis_kelamin_laki" value="L"
                                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jenis_kelamin_laki">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="P"
                                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jenis_kelamin_perempuan">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>

                            <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" placeholder="alamat"
                                name="alamat" id="alamat" rows="5">{{ old('alamat', $siswa->alamat) }}</textarea>
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
                <button type="submit" class="btn btn-primary profile-button">Update Siswa</button>
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
