@extends('layouts.app')

@dump(session()->all())

@section('content')
<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12 d-flex align-items-center flex-column">
                                    <label for="potoProfile" class="image-hover @error('poto_guru') border border-danger @enderror">
                                        <span class="edit-icon"></span>
                                        <img id="profileImage" src="{{ asset('images/profiledefault.jpg') }}"
                                            alt="Photo profile" width="100">
                                    </label>
                                    <input type="file" name="poto_guru" id="potoProfile" class="d-none @error('poto_guru') is-invalid @enderror">
                                    @error('poto_guru')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <h5 class="mt-2">Photo Anda</h5>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                     autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description') }}(Optional)</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jurusan_id" class="col-md-4 col-form-label text-md-end">Ketua Jurusan</label>

                                <div class="col-md-6 form-group">
                                    <select class="form-control @error('jurusan_id') is-invalid @enderror" name="jurusan_id" id="jurusan_id">
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->id }}" {{ old('jurusan_id') == $item->id ? "selected" : '' }}>{{ $item->jurusan }}</option>
                                        @endforeach
                                    </select>

                                    @error('jurusan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('potoProfile').addEventListener('change', function(event) {
        const inputFile = event.target;
        const profileImage = document.getElementById('profileImage');

        if (inputFile.files && inputFile.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                profileImage.src = e.target.result;
            };

            reader.readAsDataURL(inputFile.files[0]);
        }
    });
    </script>
@endsection
