@extends('layouts.nav-admin')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Tambah Kelompok Siswa PKL</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
    <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
    <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Kelompok Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Tambah Kelompok Siswa PKL</h4>
        </div>
        <form action="{{ route('admin.kelompok-siswa.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="nama" class="form-label">Nama Kelompok</label>

                            <input type="text" class="form-control @error('nama_kelompok') is-invalid @enderror"
                                placeholder="nama kelompok" name="nama_kelompok" id="nama" value="{{ old('nama_kelompok') }}">
                            @error('nama_kelompok')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="dudi_id" class="form-label">Nama DuDi</label>

                            <select name="dudi_id" id="dudi_id" class="form-select">
                                <option selected disabled>Pilih Dudi</option>
                                @foreach ($dudi as $item)
                                    <option value="{{ $item->id }}" {{ old('dudi_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('dudi_id')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="guru_id" class="form-label">Nama Pengurus/Pembimbing</label>

                            <select name="guru_id" id="guru_id" class="form-select">
                                <option selected disabled>Pilih Pengurus/Pembimbing</option>
                                @foreach ($guru as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('guru_id') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="mb-3 mt-3">
                        <label class="form-label">Daftar Anggota</label>
                        <select class="select2 form-select select2-multiple @error('anggota') is-invalid @enderror"
                            multiple="multiple" id="anggota" name="anggota[]" data-placeholder="Daftar Anggota Kelompok">
                            <optgroup label="Daftar Anggota Kelompok">
                                @foreach ($anggota as $data)
                                    <option value="{{ $data->id }}"
                                        {{ in_array($data->id, old('anggota', [])) ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('anggota')
                            <div class="invalid-feedback">
                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md12 mt-5 text-start">
                    <button type="submit" class="btn btn-primary profile-button">Tambah Siswa</button>
                </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#anggota').select2();
            $('#guru_id').select2();
            $('#dudi_id').select2();
        });
    </script>
@endsection
