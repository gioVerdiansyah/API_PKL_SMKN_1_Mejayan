@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/dashboard.css') }}">
    <div class="row justify-content-center flex-wrap">
        <div class="col-md-3">
            <div class="card text-white bg-primary bg-gradient h-100 d-flex flex-row align-items-center">
                <div class="card-body">
                    <i class="link-icon" data-feather="users"></i>
                </div>
                <div class="card-body text-end">
                    <h5 class="card-title">Siswa-siswi PKL</h5>
                    <p class="card-text">{{ $user }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info bg-gradient h-100 d-flex flex-row align-items-center">
                <div class="card-body">
                    <i class="mdi mdi-factory fs-3"></i>
                </div>
                <div class="card-body text-end">
                    <h5 class="card-title">DuDi</h5>
                    <p class="card-text">{{ $dudi }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success bg-gradient h-100 d-flex flex-row align-items-center">
                <div class="card-body">
                    <i class="fa-solid fa-user-tie fs-3"></i>
                </div>
                <div class="card-body text-end">
                    <h5 class="card-title">Pengurus PKL</h5>
                    <p class="card-text">{{ $guru }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-secondary bg-gradient h-100 d-flex flex-row align-items-center">
                <div class="card-body">
                    <i class="link-icon" data-feather="box"></i>
                </div>
                <div class="card-body text-end">
                    <h5 class="card-title">Kelompok PKL</h5>
                    <p class="card-text">{{ $kelompok }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content my-5">
        <figure class="text-center">
            <blockquote class="blockquote">
                <h1>Welcome Admin PKL SMKN 1 Mejayan</h1>
            </blockquote>
            <figcaption class="blockquote-footer fs-4" id="admin-kuasa">
                Lu Admin, lu punya <cite title="Source Title">kuasa</cite> &#9994
            </figcaption>
            <figcaption class="blockquote-footer fs-6">
                Namun ingat, di atas Admin masih ada <cite title="Source Title">Developer!</cite>
            </figcaption>
        </figure>
    </div>
@endsection
