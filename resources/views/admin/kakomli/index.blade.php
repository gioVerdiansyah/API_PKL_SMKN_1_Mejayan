@extends('layouts.nav-admin')

@section('content')
    <title>Admin - Kakomli</title>
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Data-data Kakomli</li>
                </ol>
            </nav>
        </div>
        <div class="text-end">
            <a href="{{ route('kakomli.create') }}" class="btn btn-outline-primary">Tambah Kakomli</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Photo Profile</th>
                            <th>Nama</th>
                            <th>Ketua Jurusan</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kakomli as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td>
                                    <img src="{{ asset($data->photo_profile) }}" alt="Photo profile Kakomli" width="70">
                                </td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->jurusan->jurusan }}</td>
                                <td>{{ $data->email }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('kakomli.edit', $data->id) }}" class="btn btn-warning px-2 py-1"><i
                                            class="link-icon" width="15" data-feather="edit"></i></a>
                                    <form action="{{ route('kakomli.destroy', $data->id) }}" method="POST"
                                        nameKakomli="{{ $data->nama }}" class="delete">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger px-2 py-1"><i class="link-icon"
                                                width="15" data-feather="delete"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="mt-3 mb-3 text-center fw-bold">Tidak ada data kakomli</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 align-items-center">
                {{-- {{ $industris->links('pagination::bootstrap-5') }} --}}
            </div>
        </div>
    </div>
    <script>
        if (document.querySelectorAll('.delete').length > 0) {
            document.querySelectorAll('.delete').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    var nameKakomli = form.getAttribute('nameKakomli');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Ingin menghapus kakomli '" + nameKakomli + "'?",
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
            });
        }
    </script>
@endsection
