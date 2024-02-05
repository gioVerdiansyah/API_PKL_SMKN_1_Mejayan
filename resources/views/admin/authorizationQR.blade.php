@extends('layouts.nav-admin')

@section('content')
    <div class="card p-4 mb-4 flex-md-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Synchronization Data</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body pt-3 d-flex flex-column align-items-center">
            <p class="text-muted align-self-start">Authorization QR</p>
            <div class="col-md-6 d-flex flex-column align-items-center" id="to-fetch">
                @if (!empty($response->data))
                    <img src="{{ $response->data->qr }}" alt="QR wa" class="text-center">
                @else
                    <p class="btn btn-success text-white">WA sudah aktif</p>
                @endif
            </div>
        </div>
    </div>
@endsection
