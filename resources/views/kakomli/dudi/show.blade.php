@extends('layouts.nav-kakomli')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Detail dudi {{ $dudi->nama }}</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/css/demo1/profile-edit.css') }}">
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dudi.index') }}">Dudi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Dudi</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-5">
            <h4 class="mt-2">Dudi {{ $dudi->nama }}</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Pemimpin Dudi</label>
                        <p>{{ $dudi->pemimpin }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Nomor Telepon</label>
                        <p>{{ $dudi->no_telp ?? 'tidak ada nomor telepon' }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Email</label>
                        <p>{{ $dudi->email ?? 'tidak ada email' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Koordinat</label>
                        <p>{{ $dudi->koordinat }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Radius</label>
                        <p>{{ $dudi->radius }}m</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Alamat</label>
                        <p>{{ $dudi->alamat }}</p>
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
                        <label class="form-label">Senin</label>
                        <p>{{ $dudi->senin }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Selasa</label>
                        <p>{{ $dudi->selasa }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Rabu</label>
                        <p>{{ $dudi->rabu }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Kamis</label>
                        <p>{{ $dudi->kamis }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Juma'at</label>
                        <p>{{ $dudi->jumat }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Saptu</label>
                        <p>{{ $dudi->saptu ?? 'libur' }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Minggu</label>
                        <p>{{ $dudi->minggu ?? 'libur' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat senin</label>
                        <p>{{ $dudi->ji_senin }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat selasa</label>
                        <p>{{ $dudi->ji_selasa }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat rabu</label>
                        <p>{{ $dudi->ji_rabu }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat kamis</label>
                        <p>{{ $dudi->ji_kamis }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat juma'at</label>
                        <p>{{ $dudi->ji_jumat }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat saptu</label>
                        <p>{{ $dudi->ji_saptu ?? 'libur' }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jam istirahat minggu</label>
                        <p>{{ $dudi->ji_minggu ?? 'libur' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md12 mt-5 text-start">
            <button class="btn btn-warning profile-button">Edit</button>
            <button class="btn btn-danger profile-button">Hapus</button>
        </div>
    </div>
    </div>
    </div>
    <script>
        @error('sosmed-group')
            Swal.fire({
                icon: 'error',
                title: "Gagal",
                text: "Sosial media tidak boleh kosong!"
            });
        @enderror
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
