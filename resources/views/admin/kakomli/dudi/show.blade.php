@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Detail dudi {{ $dudi->nama }}</title>
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
                        <p>{!! $dudi->no_telp ? "<a href='https://api.whatsapp.com/send?phone=$dudi->no_telp' target='_blank'>$dudi->no_telp</a>" :
                            '<p>tidak ada no telp</p>' !!}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Email</label>
                        <p>{!! $dudi->email ? "<a href='mailto:$dudi->email' target='_blank'>$dudi->email</a>" : 'tidak ada email' !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Koordinat</label>
                        <p>
                            @php
                                $link =
                                    'https://www.google.com/maps/@' . str_replace(' ', '', $dudi->koordinat) . ',20z';
                            @endphp
                            <a href={{ $link }} target="_blank">{{ $dudi->koordinat }}</a>
                        </p>
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
