@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Tambah siswa PKL</title>
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <div class="card p-4 mb-4 flex-row justify-content-md-between flex-column flex-md-row align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#uploadDataByExcel">Tambah Siswa
                PKL
                by Excel</button>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Tambah Siswa PKL</h4>
        </div>
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex flex-column align-items-center pb-2">
                <label for="potoProfile" class="image-hover">
                    <span class="edit-icon"></span>
                    <img id="profileImage" src="{{ asset('images/mobile/default_photo.png') }}" alt="Photo profile"
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
                                placeholder="nama siswa" name="nama" id="nama" value="{{ old('nama') }}">
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
                                name="nis" id="nis" value="{{ old('nis') }}">
                            @error('nis')
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
                                placeholder="email" name="email" id="email" value="{{ old('email') }}">
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
                                value="{{ old('no_telp') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="no_hp_ortu" class="form-label">No HP ortu</label>

                            <input type="number" class="form-control" placeholder="no hp ortu" name="no_hp_ortu"
                                id="no_hp_ortu" value="{{ old('no_hp_ortu') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="absen" class="form-label">Absen</label>

                            <input type="number" class="form-control @error('absen') is-invalid @enderror"
                                placeholder="absen" name="absen" id="absen"
                                value="{{ old('absen') != null ? old('absen') + 1 ?? '' : '' }}">
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
                                        {{ old('kelas') == $item->id ? 'selected' : '' }}>{{ $item->kelas }}</option>
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
                                        {{ old('jurusan') == $item->id ? 'selected' : '' }}>{{ $item->jurusan }}</option>
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
                                        {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jenis_kelamin_laki">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio" name="jenis_kelamin" id="jenis_kelamin_perempuan" value="P"
                                        {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
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
                                name="alamat" id="alamat" rows="5">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <span class="fw-bold">Jam Dudi</span>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="senin" class="form-label">Senin</label>
                                <input type="text" class="form-control @error('senin') is-invalid @enderror"
                                    placeholder="jam masuk senin" name="senin" id="senin"
                                    value="{{ old('senin', '08:00 - 16:00') }}" required>
                                @error('senin')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="rabu" class="form-label">Rabu</label>
                                <input type="text" class="form-control @error('rabu') is-invalid @enderror"
                                    placeholder="jam masuk rabu" name="rabu" id="rabu"
                                    value="{{ old('rabu', '08:00 - 16:00') }}" required>
                                @error('rabu')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="jumat" class="form-label">Juma'at</label>
                                <input type="text" class="form-control @error('jumat') is-invalid @enderror"
                                    placeholder="jam masuk jumat" name="jumat" id="jumat"
                                    value="{{ old('jumat', '08:00 - 16:00') }}" required>
                                @error('jumat')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="minggu" class="form-label">Minggu</label>
                                <input type="text" class="form-control @error('minggu') is-invalid @enderror"
                                    placeholder="jam masuk minggu" name="minggu" id="minggu"
                                    value="{{ old('minggu') }}">
                                @error('minggu')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="selasa" class="form-label">Selasa</label>
                                <input type="text" class="form-control @error('selasa') is-invalid @enderror"
                                    placeholder="jam masuk selasa" name="selasa" id="selasa"
                                    value="{{ old('selasa', '08:00 - 16:00') }}" required>
                                @error('selasa')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="kamis" class="form-label">Kamis</label>
                                <input type="text" class="form-control @error('kamis') is-invalid @enderror"
                                    placeholder="jam masuk kamis" name="kamis" id="kamis"
                                    value="{{ old('kamis', '08:00 - 16:00') }}" required>
                                @error('kamis')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-1">
                                <label for="sabtu" class="form-label">Sabtu</label>
                                <input type="text" class="form-control @error('sabtu') is-invalid @enderror"
                                    placeholder="jam masuk sabtu" name="sabtu" id="sabtu"
                                    value="{{ old('sabtu') }}">
                                @error('sabtu')
                                    <div>
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-md12 mt-5 text-start">
                <button type="submit" class="btn btn-primary profile-button">Tambah Siswa</button>
            </div>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="uploadDataByExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="uploadDataByExcelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadDataByExcelLabel">Export data siswa by Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                         <div>
                            <p class="text-bold">*Note</p>
                            <ul>
                                <li>id tidak usah di isi</li>
                                <li>photo_name tidak usah di isi</li>
                                <li>Password tidak usah di isi, karena default adalah nis</li>
                                <li>jurusan_id harus di isi dengan singkatan juruan, misal RPL</li>
                                <li>kelas_id harus di isi seperti XII RPL 2</li>
                                <li>senin sampai jumat harus di isi seperti 08:00 - 16:00 jam 8 adalah waktu mulai PKL sedangkan jam 4 adalah waktu pulang PKL, saptu minggu adalah opsional</li>
                                <li>jenis_kelamin L atau P</li>
                                <li>created_at tidak usah di isi</li>
                                <li>updated_at tidak usah di isi</li>
                                <li>remember_token tidak usah di isi</li>
                            </ul>
                        </div>
                        <a href="{{ route('admin.siswa.download_list_table') }}" type="button"
                            class="btn btn-primary">download list kolom</a>
                        <form action="{{ route('admin.siswa.import_data') }}" method="POST"
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
