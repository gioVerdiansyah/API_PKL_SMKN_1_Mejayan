<link rel="stylesheet" href="/css/bootstrap.min.css">

<div class="px-5 py-3">
    <div class="header">
        <h4 class="m-0">Data Tempat PKL</h4>
        <h4 class="m-0">{{ $jurusan->jurusan }} SMKN 1 MEJAYAN</h4>
        <h4 class="m-0">THN. {{ date('Y') }}</h4>
    </div>
    <table class="table table-striped table-bordered mt-3">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama DuDi</th>
                <th scope="col">Pembimbing DuDi/Owner</th>
                <th scope="col">No Telp/WA - Email</th>
                <th scope="col">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dudi as $i => $item)
                <tr>
                    <th scope="row">{{ ++$i }}</th>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pemimpin }}</td>
                    <td>
                        @if ($item->no_telp && $item->email)
                            {{ $item->no_telp }} - {{ $item->email }}
                        @elseif ($item->no_telp)
                            {{ $item->no_telp }}
                        @elseif ($item->email)
                            {{ $item->email }}
                        @else
                            Tidak ada no telp dan email
                        @endif
                    </td>
                    <td style="white-space: initial;width: 35%;">{{ $item->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    window.addEventListener('load', function() {
    window.print({
        landscape: false,
        headers: false,
        options: false
    });
    window.onafterprint = function() {
        alert("tekan ctrl + p untuk print lagi");
    }
});
</script>
