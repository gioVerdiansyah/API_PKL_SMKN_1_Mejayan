@extends('layouts.app')

@section('content')
    <div class="container my-3">
        <div id="content">
            <div id="button-download">
                <button onclick="generatePdf()">Generate Jurnal Anda</button>
            </div>
        </div>
    </div>

    <script>
        const generatePdf = () => {
            $.ajax({
                type: "post",
                url: "{{ route('print_jurnal') }}",
                data: {
                    user_id: '{{ $id }}',
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function(){
                    $('#content').append(`
                        <div id="message-loading">
                            <p>PDF anda sedang di generate mohon tunggu</p>
                        </div>
                    `);
                },
                success: function (response) {
                    console.log(response);
                    $('#button-download').html(`
                        <a href="${response.pdf_url}" download="${response.name_file}">Download File</a>
                    `);
                    $('#message-loading').html(`
                        <p style="color: ${response.success ? 'green' : 'red'}">${response.message}</p>
                    `);
                }
            });
        }
    </script>
@endsection
