<link rel="stylesheet" href="/css/bootstrap.min.css">

<style>
    @page {
        size: landscape;
    }

        table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 2px solid black;
        padding: 8px;
        text-align: left;
        font-size: 10px
    }
</style>

<div class="p-3">
    <div class="header text-center text-uppercase">
        <h4 class="m-0">DATA PESERTA PRAKTIK KERJA LAPANGAN</h4>
        <h4 class="m-0">JURUSAN {{ $jurusan->full_name }}</h4>
        <h4 class="m-0">SMK NEGRI 1 MEJAYAN</h4>
        <h4 class="m-0">TAHUN PEMBELAJARAN {{ date('Y') }}/{{ date('Y', strtotime('+1 year')) }}</h4>
    </div>
    <table class="table table-bordered mt-3">
        <thead>
            <tr class="table-warning">
                <th scope="col">KELOMPOK</th>
                <th scope="col">KELAS</th>
                <th scope="col">NOMOR INDUK</th>
                <th scope="col">NAMA SISWA</th>
                <th scope="col">DUDI TEMPAT PRAKERIN</th>
                <th scope="col">NAMA PIMPINAN DUDI</th>
                <th scope="col">NO. TELP/HP DUDI</th>
                <th scope="col">ALAMAT DUDI</th>
                <th scope="col">PEMBIMBING</th>
            </tr>
            <tr class="table-light">
                <th scope="col">1</th>
                <th scope="col">2</th>
                <th scope="col">3</th>
                <th scope="col">4</th>
                <th scope="col">5</th>
                <th scope="col">6</th>
                <th scope="col">7</th>
                <th scope="col">8</th>
                <th scope="col">9</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelompok as $i => $item)
                @php
                    $firstAnggota = $item->anggota->first();
                    $i++;
                @endphp
                <tr class="{{ $i % 2 == 0 ? 'table-light' : 'table-secondary' }}">
                    <td>{{ $item->nama_kelompok }}</td>
                    <td>{{ $firstAnggota->user->kelas->kelas }}</td>
                    <td>{{ $firstAnggota->user->nis }}</td>
                    <td>{{ $firstAnggota->user->name }}</td>
                    <td>{{ $item->dudi->nama }}</td>
                    <td>{{ $item->dudi->pemimpin }}</td>
                    <td>{{ $item->dudi->no_telp }}</td>
                    <td>{{ $item->dudi->alamat }}</td>
                    <td>{{ $item->guru->nama }} {{ $item->guru->gelar }}</td>
                </tr>
                @foreach ($item->anggota as $j => $anggota)
                    @if ($j > 0)
                        <tr class="{{ $i % 2 == 0 ? 'table-light' : 'table-secondary' }}">
                            @php
                                ++$i;
                            @endphp
                            <td></td>
                            <td>{{ $anggota->user->kelas->kelas }}</td>
                            <td>{{ $anggota->user->nis }}</td>
                            <td>{{ $anggota->user->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                    <td colspan="9" class="table-dark"></td>
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
