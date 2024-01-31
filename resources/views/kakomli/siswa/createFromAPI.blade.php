@extends('layouts.nav-kakomli')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Tambah Siswa PKL</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
    <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
    <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Tambah Pengurus by API</h4>
        </div>
        <form action="{{ route('siswa.import_by_api') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="mb-3 mt-3">
                        <label class="form-label">Daftar Siswa</label>
                        <select class="select2 form-select select2-multiple @error('siswa_id') is-invalid @enderror"
                            multiple="multiple" id="siswa_id" name="siswa_id[]" data-placeholder="Daftar Siswa">
                            <optgroup label="Daftar Siswa">
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, old('siswa_id', [])) ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('siswa_id')
                            <div class="invalid-feedback">
                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <span class="fw-bold">Jam DuDi</span>
                <p class="fs-6 text-secondary">Note: Siswa di atas jam dudinya akan sama di bawah</p>
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

                <div class="col-md12 mt-2 text-start">
                    <button type="submit" class="btn btn-primary profile-button">Tambah Siswa</button>
                </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#siswa_id').select2();
        });
    </script>
@endsection
