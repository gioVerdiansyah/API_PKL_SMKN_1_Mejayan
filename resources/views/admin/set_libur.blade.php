@extends('layouts.nav-admin')

@section('content')
    <title>Synchronization Data</title>
    <div class="card p-4 mb-4 flex-md-row justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dot mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Set Libur</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body pt-3 d-flex flex-column align-items-center">
            <p class="text-muted align-self-start">Set Libur Hari ini</p>
            <form id="sent" class="col-md-6 d-flex flex-column align-items-center" method="POST" action="{{ route('admin.set_libur_sent') }}">
                @csrf
                <button type="sbumit" class="btn btn-warning text-white p-3 px-5" id="synchronization">
                    <p>LIBUR</p>
                </button>
                <div class="mt-2 row w-100" id="message"></div>
            </form>
        </div>
    </div>
        <script>
        const form = document.getElementById('sent');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var nameSiswa = form.getAttribute('nameSiswa');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Pastikan bahwa hari ini benar-benar libur karena akan me-update status absen siswa menjadi libur",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya!",
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
