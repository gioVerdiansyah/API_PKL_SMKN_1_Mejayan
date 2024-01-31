@extends('layouts.nav-admin')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Tambah Pengurus PKL</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/vendors/select2/select2.min.css') }}">
    <script src="{{ asset('cssAdmin/js/select2.js') }}"></script>
    <script src="{{ asset('cssAdmin/vendors/select2/select2.min.js') }}"></script>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.pengurus-pkl.index') }}">Pengurus PKL</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Tambah Pengurus by API</h4>
        </div>
        <form action="{{ route('admin.pengurus-pkl.import_by_api') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="mb-3 mt-3">
                        <label class="form-label">Daftar Guru</label>
                        <select class="select2 form-select select2-multiple @error('guru_id') is-invalid @enderror"
                            multiple="multiple" id="guru_id" name="guru_id[]" data-placeholder="Daftar Guru">
                            <optgroup label="Daftar Guru">
                                @foreach ($data as $item)
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, old('guru_id', [])) ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('guru_id')
                            <div class="invalid-feedback">
                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md12 mt-2 text-start">
                    <button type="submit" class="btn btn-primary profile-button">Tambah Siswa</button>
                </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#guru_id').select2();
        });
    </script>
@endsection
