@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Edit dudi</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
    <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
    <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dudi.index') }}">Dudi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-5">
            <h4 class="mt-2">Edit Dudi</h4>
        </div>
        <form action="{{ route('admin.dudi.update', $dudi->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="nama" class="form-label">Nama Dudi</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                placeholder="nama dudi" name="nama" id="nama"
                                value="{{ old('nama', $dudi->nama) }}">
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
                                value="{{ old('pemimpin', $dudi->pemimpin) }}">
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
                                value="{{ old('no_telp', $dudi->no_telp) }}">
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
                                placeholder="Email dudi" name="email" id="email"
                                value="{{ old('email', $dudi->email) }}">
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
                                        {{ old('jurusan_id', $dudi->jurusan_id) == $item->id ? 'selected' : '' }}>
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
                                name="koordinat" id="koordinat" value="{{ old('koordinat', $dudi->koordinat) }}">
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
                                value="{{ old('radius', $dudi->radius) }}">
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
                                placeholder="Alamat dudi" name="alamat" id="alamat"
                                value="{{ old('alamat', $dudi->alamat) }}">
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
                <button type="submit" class="btn btn-warning profile-button">Edit Dudi</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#jurusan_id').select2();
        });
    </script>
@endsection
