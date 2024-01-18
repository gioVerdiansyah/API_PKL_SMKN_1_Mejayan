@extends('layouts.nav-kakomli')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Detail kelompok {{ $kelompok->nama }}</title>
    <style>
        #list-siswa li:nth-child(odd){
            margin-right: 40px
        }
    </style>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('kelompok-siswa.index') }}">Kelompok</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-2">
            <h4 class="mt-2">Detail Kelompok</h4>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <p class="text-bold fw-bolder">Nama Kelompok</p>
                        <p>{{ $kelompok->nama_kelompok }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <p class="text-bold fw-bolder">Nama DuDi</p>
                        <p>{{ $kelompok->dudi->nama }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <p class="text-bold fw-bolder">Nama Pengurus/Pembimbing</p>
                        <p>{{ $kelompok->guru->nama }} {{ $kelompok->guru->gelar }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="mb-3 mt-3">
                    <p class="text-bold fw-bolder">Daftar Anggota</p>
                    <ol class="d-flex flex-wrap" id="list-siswa">
                        @foreach ($kelompok->anggota as $item)
                            <li>{{ $item->users->name }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <div class="col-md12 mt-5 text-start d-flex">
                <a href="{{ route('kelompok-siswa.edit', $kelompok->id) }}" class="btn btn-warning profile-button">Edit</a>
                <form nameKelompok="{{ $kelompok->nama_kelompok }}" action="{{ route('kelompok-siswa.destroy', $kelompok->id) }}" method="POST" id="delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger profile-button ms-2">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('delete');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var nameKelompok = form.getAttribute('nameKelompok');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus kelompok '" + nameKelompok + "'?",
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
