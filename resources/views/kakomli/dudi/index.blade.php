@extends('layouts.nav-kakomli')

@section('content')
    <div class="card p-4 mb-4 flex-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Data-data Dudi</li>
                </ol>
            </nav>
        </div>
        <div class="text-end">
            <a href="{{ route('dudi.create') }}" class="btn btn-outline-primary">Tambah Dudi</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table"  style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Pemimpin Dudi</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dudi as $i => $data)
                            <tr>
                                <th>{{ ++$i }}</th>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->pemimpin }}</td>
                                <td>{{ $data->no_telp ?? 'tidak ada no telp' }}</td>
                                <td style="white-space: initial">{{ $data->alamat }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('dudi.show', $data->id) }}" class="btn btn-primary px-2 py-1"><i
                                            class="link-icon" width="15" data-feather="file-text"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="mt-3 mb-3 text-center fw-bold">Tidak ada data dudi</p>
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
                    var nameDudi = form.getAttribute('nameDudi');
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Ingin menghapus dudi '" + nameDudi + "'?",
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
