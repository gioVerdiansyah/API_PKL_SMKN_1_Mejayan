@extends('layouts.app')
@section('content')
    <section class="section gradient-banner" style="padding: 100px 0 100px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <div class="logo d-flex flex-column align-items-center">
                                    <img src="{{ asset('images/app/Logo_SMK.png') }}" class="img-circle" style="width: 15%" alt="Logo SMK">
                                    <h4 class="font-weight-bold mt-1">SMKN 1 Mejayan</h4>
                                    <h4 class="absensi-trouble-title mt-1 align-self-start">Absensi Trouble</h4>
                                </div>
                                <form action="{{ route('absen-trouble') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                                <input type="hidden" name="rm_token" value="{{ request('rm_token') }}">
                                <div class="mb-3">
                                    <label for="kategori_absen" class="form-label">Pilih Status</label>
                                    <select class="form-control @error('kategori_absen') is-invalid @enderror"
                                        id="kategori_absen" name="kategori_absen">
                                        <option value="" disabled selected>Pilih...</option>
                                        <option value="hadir" {{ old('kategori_absen') == 'hadir' ? 'selected' : '' }}>
                                            Hadir</option>
                                        <option value="WFH" {{ old('kategori_absen') == 'WFH' ? 'selected' : '' }}>WFH
                                        </option>
                                        <option value="pulang" {{ old('kategori_absen') == 'pulang' ? 'selected' : '' }}>
                                            Pulang</option>
                                    </select>
                                    @error('kategori_absen')
                                        <div class="invalid-feedback">Pilih status hadir dengan benar.</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success">Absen</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
