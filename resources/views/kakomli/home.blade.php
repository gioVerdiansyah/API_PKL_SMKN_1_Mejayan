@extends('layouts.nav-kakomli')

@section('content')
    <link rel="stylesheet" href="{{ asset('cssAdmin/style.css') }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    <div class="row justify-content-center dashboard-template flex-wrap ">
        <div class="col-md-4 card-dashboard h-100">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <i class="link-icon" data-feather="users"></i>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah siswa</h5>
                        <p class="card-text">{{ $user }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 card-dashboard h-100">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <i class="link-icon" data-feather="home"></i>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah DuDi</h5>
                        <p class="card-text">{{ $dudi }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 card-dashboard h-100">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <i class="link-icon" data-feather="grid" style="left: 0"></i>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah Kelompok</h5>
                        <p class="card-text">{{ $kelompok }}</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
