@extends('layouts.nav-admin')

@section('content')
  <title>{{ config('app.name', 'Laravel') }} - Kakomli</title>
  <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
  <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
  <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
  <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
    <div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dot mb-0">
          <li class="breadcrumb-item"><a href="{{ route('kakomli.index') }}">Kakomli</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('kakomli.store') }}" method="POST" class="forms-sample row">
        @csrf
        <div class="col-md-12 row mb-3">
          <div class="col-md-12">
            <div class="mb-3">
              <label class="form-label">Jurusan kakomli</label>
              <select class="select2 form-select  @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" data-placeholder="jurusan kakomli">
                  @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}"
                      {{ old('jurusan') == $jurusan->id ? 'selected' : '' }}>
                      {{ $jurusan->jurusan }}
                    </option>
                  @endforeach
              </select>
              @error('jurusan')
                <div class="invalid-feedback">
                  <p>{{ $message }}</p>
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="nama">Nama Kakomli</label>
              <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                name="nama" placeholder="Nama kakomli" value="{{ old('nama') }}">
              @error('nama')
                <div class="invalid-feedback">
                  <p>{{ $message }}</p>
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" placeholder="email kakomli" value="{{ old('email') }}">
              @error('email')
                <div class="invalid-feedback">
                  <p>{{ $message }}</p>
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" placeholder="password kakomli" value="{{ old('password') }}">
              @error('password')
                <div class="invalid-feedback">
                  <p>{{ $message }}</p>
                </div>
              @enderror
            </div>
          </div>
          <div class="col-md-6 col-12 mt-4">
            <button type="submit" class="btn btn-primary me-2">Tambah</button>
            <a class="btn btn-secondary" href="{{ route('kakomli.index') }}">Cancel</a>
          </div>
        </div>
    </div>
    </form>
  </div>
  <script>
    $(document).ready(function() {
      $('#jurusan').select2();
    });
  </script>
@endsection
