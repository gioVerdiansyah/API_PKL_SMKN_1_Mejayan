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
            <p class="text-muted align-self-start">Synchronization From API Admin</p>
            <div class="col-md-6 d-flex flex-column align-items-center" id="to-fetch">
                <link rel="stylesheet" href="{{ asset('css/button_synchronization.css') }}">
                <button type="button" class="button" id="synchronization" onclick="sync()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                        <path
                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z">
                        </path>
                        <path fill-rule="evenodd"
                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z">
                        </path>
                    </svg>
                    <p>Synchronization Data</p>
                </button>
            </div>
        </div>
    </div>

    <script>
        const sync = () => {
            $.ajax({
                type: "post",
                url: "{{ route('admin.synchronization-data') }}",
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                dataType: "json",
                beforeSend: function(){
                    $("#synchronization").addClass('loading');
                    $("#synchronization p").text("GET DATA API ....");
                },
                success: function (response) {
                    if(response.success){
                        $("#synchronization p").text("Berhasil Synchronization Data!!!");
                        $("#to-fetch").append(`
                            <div class="mt-2">
                                <p class="text-success">Pesan: ${response.message}</p>
                                <p><strong>Jurusan:  ${response.data.jurusan.create}</strong> created <strong> ${response.data.jurusan.update} </strong> updated</p>
                                <p><strong>Kelas:  ${response.data.kelas.create} </strong> created <strong> ${response.data.kelas.update} </strong> updated</p>
                            </div>
                        `);
                    }else{
                        $("#synchronization p").text("GAGAL!!!");

                        $("#to-fetch").append(`
                            <div class="mt-2">
                                <p class="text-danger">Pesan: ${response.message}</p>
                                <p class="text-danger">Error: ${response.error}</p>
                            </div>
                        `);
                    }
                    $("#synchronization").removeClass('loading');
                    $("#synchronization").removeAttr('onclick');
                }
            });
        };
    </script>
@endsection
