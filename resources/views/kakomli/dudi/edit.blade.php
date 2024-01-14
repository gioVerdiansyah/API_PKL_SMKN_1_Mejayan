@extends('layouts.nav-kakomli')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Edit dudi</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/css/demo1/profile-edit.css') }}">
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dudi.index') }}">Dudi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-5">
            <h4 class="mt-2">Tambah Dudi</h4>
        </div>
        <form action="{{ route('dudi.update', $dudi->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="d-flex flex-column align-items-center">
                <label for="nama" class="form-label">Nama Dudi</label>
                <input type="text" class="form-control w-25 @error('nama') is-invalid @enderror" placeholder="nama dudi"
                    name="nama" id="nama" value="{{ old('nama', $dudi->nama) }}">
                @error('nama')
                    <div>
                        <p class="text-danger mt-2">{{ $message }}</p>
                    </div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
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
                            <label for="no_telp" class="form-label">Nomor Telepon</label>
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
                                placeholder="Email dudi" name="email" id="email" value="{{ old('email', $dudi->email) }}">
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
                                placeholder="Radius tempat dudi" name="radius" id="radius" value="{{ old('radius', $dudi->radius) }}">
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
                                placeholder="Alamat dudi" name="alamat" id="alamat" value="{{ old('alamat', $dudi->alamat) }}">
                            @error('alamat')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- jam dudi --}}
            <span class="fw-bold">Jam Dudi</span>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="senin" class="form-label">Senin</label>
                            <input type="text" class="form-control @error('senin') is-invalid @enderror"
                                placeholder="jam masuk senin" name="senin" id="senin"
                                value="{{ old('senin', $dudi->senin) }}" required>
                            @error('senin')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="selasa" class="form-label">Selasa</label>
                            <input type="text" class="form-control @error('selasa') is-invalid @enderror"
                                placeholder="jam masuk selasa" name="selasa" id="selasa"
                                value="{{ old('selasa', $dudi->selasa) }}" required>
                            @error('selasa')
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
                                value="{{ old('rabu', $dudi->rabu) }}" required>
                            @error('rabu')
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
                                value="{{ old('kamis', $dudi->kamis) }}" required>
                            @error('kamis')
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
                                value="{{ old('jumat', $dudi->jumat) }}" required>
                            @error('jumat')
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
                                value="{{ old('sabtu', $dudi->sabtu) }}">
                            @error('sabtu')
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
                                value="{{ old('minggu', $dudi->minggu) }}">
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
                            <label for="ji_senin" class="form-label">Jam istirahat senin</label>
                            <input type="text" class="form-control @error('ji_senin') is-invalid @enderror"
                                placeholder="jam istirahat senin" name="ji_senin" id="ji_senin"
                                value="{{ old('ji_senin', $dudi->ji_senin) }}" required>
                            @error('ji_senin')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="ji_selasa" class="form-label">Jam istirahat selasa</label>
                            <input type="text" class="form-control @error('ji_selasa') is-invalid @enderror"
                                placeholder="jam istirahat selasa" name="ji_selasa" id="ji_selasa"
                                value="{{ old('ji_selasa', $dudi->ji_selasa) }}" required>
                            @error('ji_selasa')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="ji_rabu" class="form-label">Jam istirahat rabu</label>
                            <input type="text" class="form-control @error('ji_rabu') is-invalid @enderror"
                                placeholder="jam istirahat rabu" name="ji_rabu" id="ji_rabu"
                                value="{{ old('ji_rabu', $dudi->ji_rabu) }}" required>
                            @error('ji_rabu')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="ji_kamis" class="form-label">Jam istirahat kamis</label>
                            <input type="text" class="form-control @error('ji_kamis') is-invalid @enderror"
                                placeholder="jam istirahat kamis" name="ji_kamis" id="ji_kamis"
                                value="{{ old('ji_kamis', $dudi->ji_kamis) }}" required>
                            @error('ji_kamis')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="ji_jumat" class="form-label">Jam istirahat juma'at</label>
                            <input type="text" class="form-control @error('ji_jumat') is-invalid @enderror"
                                placeholder="jam istirahat jumat" name="ji_jumat" id="ji_jumat"
                                value="{{ old('ji_jumat', $dudi->ji_jumat) }}" required>
                            @error('ji_jumat')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="ji_sabtu" class="form-label">Jam istirahat sabtu</label>
                            <input type="text" class="form-control @error('ji_sabtu') is-invalid @enderror"
                                placeholder="jam istirahat sabtu" name="ji_sabtu" id="ji_sabtu"
                                value="{{ old('ji_sabtu', $dudi->ji_sabtu) }}">
                            @error('ji_japtu')
                                <div>
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label for="ji_minggu" class="form-label">Jam istirahat minggu</label>
                            <input type="text" class="form-control @error('ji_minggu') is-invalid @enderror"
                                placeholder="jam istirahat minggu" name="ji_minggu" id="ji_minggu"
                                value="{{ old('ji_minggu', $dudi->ji_minggu) }}">
                            @error('ji_minggu')
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
@endsection
