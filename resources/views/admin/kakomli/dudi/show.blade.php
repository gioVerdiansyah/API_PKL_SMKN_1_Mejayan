@extends('layouts.nav-admin')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Detail dudi {{ $dudi->nama }}</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/css/demo1/profile-edit.css') }}">
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dudi.index') }}">Dudi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
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

        <div class="col-md12 d-flex mt-5 text-start">
            <a href="{{ route('admin.dudi.edit', $dudi->id) }}" class="btn btn-warning profile-button me-2">Edit</a>
            <form nameDudi="{{ $dudi->nama }}" action="{{ route('admin.dudi.destroy', $dudi->id) }}" id="delete" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger profile-button">Hapus</button>
            </form>
        </div>
    </div>
    <script>
        const form = document.getElementById('delete');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var nameDudi = form.getAttribute('nameDudi');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus dudi '" + nameDudi + "'?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                background: 'var(--bs-body-bg)',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection