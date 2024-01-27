@extends('layouts.nav-kakomli')

@section('content')
    <title>{{ config('app.name', 'Laravel') }} - Detail dudi {{ $siswa->nama }}</title>
    <link rel="stylesheet" href="{{ asset('cssAdmin/css/demo1/profile-edit.css') }}">
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dudi.index') }}">Siswa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card p-4">
        <div class="d-flex flex-column align-items-center pb-5">
            <img src="{{ asset($siswa->photo_profile) }}" alt="photo siswa" class="rounded-5 shadow-sm border"
                width="70">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Nama</label>
                        <p>{{ $siswa->name }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">NIS</label>
                        <p>{{ $siswa->nis }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Email</label>
                        <p>{{ $siswa->email }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">No Telp</label>
                        <p>{{ $siswa->no_telp ?? 'tidak ada nomor telephone' }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">No HP ortu</label>
                        <p>{{ $siswa->no_hp_ortu ?? 'tidak ada nomor hp ortu' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Absen</label>
                        <p>{{ $siswa->absen }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">kelas</label>
                        <p>{{ $siswa->kelas->kelas }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jurusan</label>
                        <p>{{ $siswa->jurusan->jurusan }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 mt-1">
                        <label class="form-label">Jenis Kelamin</label>
                        <p>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Alamat</label>
                        <p>{{ $siswa->alamat }}</p>
                    </div>
                </div>
            </div>
            {{-- jam masuk --}}
            <span class="fw-bold">Jam masuk siswa</span>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Senin</label>
                            <p>{{ $siswa->senin }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Rabu</label>
                            <p>{{ $siswa->rabu }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Juma'at</label>
                            <p>{{ $siswa->jumat }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Minggu</label>
                            <p>{{ $siswa->minggu ?? 'libur' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Selasa</label>
                            <p>{{ $siswa->selasa }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Kamis</label>
                            <p>{{ $siswa->kamis }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mt-1">
                            <label class="form-label">Saptu</label>
                            <p>{{ $siswa->saptu ?? 'libur' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md12 d-flex mt-5 text-start">
            <a href="{{ route('siswa.show_print_absensi_siswa', $siswa->id) }}" class="btn btn-primary profile-button me-2">Rekap Absen</a>
            <a href="{{ route('siswa.show_print_jurnal_siswa', $siswa->id) }}" class="btn btn-success profile-button me-2">Rekap Jurnal</a>
            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning profile-button me-2">Edit</a>
            <form nameSiswa="{{ $siswa->name }}" action="{{ route('siswa.destroy', $siswa->id) }}" id="delete"
                method="POST">
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
            var nameSiswa = form.getAttribute('nameSiswa');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus siswa '" + nameSiswa + "'?",
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
