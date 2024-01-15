@extends('layouts.nav-kakomli')

@section('content')
    <link rel="stylesheet" href="{{ asset('cssAdmin/style.css') }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    <div class="row justify-content-center dashboard-template flex-wrap ">
        <div class="col-md-4 card-dashboard">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah siswa</h5>
                        <p class="card-text">78</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 card-dashboard">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-book-open">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah DuDi</h5>
                        <p class="card-text">7</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 card-dashboard">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox">
                            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12" />
                            <path
                                d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z" />
                        </svg>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah Pengurus</h5>
                        <p class="card-text">78</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 card-dashboard">
            <div class="card card-detail text-white h-100">
                <div class="card-body text-end">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox">
                            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12" />
                            <path
                                d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z" />
                        </svg>
                    </div>
                    <div class="text-text">
                        <h5 class="card-title">Jumlah Kelompok</h5>
                        <p class="card-text">78</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
