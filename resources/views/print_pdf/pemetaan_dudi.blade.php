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
        <h4 class="m-0">SMK NEGERI 1 MEJAYAN</h4>
        <h4 class="m-0">TAHUN PEMBELAJARAN {{ date('Y') }}/{{ date('Y', strtotime('+1 year')) }}</h4>
    </div>
    <table class="table table-bordered mt-3">
        <thead>
            <tr class="table-warning">
                <th scope="col" class="text-center">KELOMPOK</th>
                <th scope="col" class="text-center">KELAS</th>
                <th scope="col" class="text-center">NOMOR INDUK</th>
                <th scope="col" class="text-center">NAMA SISWA</th>
                <th scope="col" class="text-center">DUDI TEMPAT PRAKERIN</th>
                <th scope="col" class="text-center">NAMA PIMPINAN DUDI</th>
                <th scope="col" class="text-center">NO. TELP/HP DUDI</th>
                <th scope="col" class="text-center">ALAMAT DUDI</th>
                <th scope="col" class="text-center">PEMBIMBING</th>
            </tr>
            <tr class="table-light">
                <th scope="col" class="text-center">1</th>
                <th scope="col" class="text-center">2</th>
                <th scope="col" class="text-center">3</th>
                <th scope="col" class="text-center">4</th>
                <th scope="col" class="text-center">5</th>
                <th scope="col" class="text-center">6</th>
                <th scope="col" class="text-center">7</th>
                <th scope="col" class="text-center">8</th>
                <th scope="col" class="text-center">9</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelompok as $i => $item)
                @php
                    $firstAnggota = $item->anggota->first();
                    $i++;
                @endphp
                <tr class="{{ $i % 2 == 0 ? 'table-light' : 'table-secondary' }}">
                    <td rowspan="{{ count($item->anggota) }}" class="text-center align-middle">{{ $item->nama_kelompok }}</td>
                    <td>{{ $firstAnggota->users->kelas->kelas }}</td>
                    <td>{{ $firstAnggota->users->nis }}</td>
                    <td>{{ $firstAnggota->users->name }}</td>
                    <td rowspan="{{ count($item->anggota) }}" class="text-center align-middle">{{ $item->dudi->nama }}</td>
                    <td rowspan="{{ count($item->anggota) }}" class="text-center align-middle">{{ $item->dudi->pemimpin }}</td>
                    <td rowspan="{{ count($item->anggota) }}" class="text-center align-middle">{{ $item->dudi->no_telp }}</td>
                    <td rowspan="{{ count($item->anggota) }}" class="text-center align-middle">{{ $item->dudi->alamat }}</td>
                    <td rowspan="{{ count($item->anggota) }}" class="text-center align-middle">{{ $item->guru->nama }} {{ $item->guru->gelar }}</td>
                </tr>
                @foreach ($item->anggota as $j => $anggota)
                    @if ($j > 0)
                        <tr class="{{ $i % 2 == 0 ? 'table-light' : 'table-secondary' }}">
                            @php
                                ++$i;
                            @endphp
                            <td>{{ $anggota->users->kelas->kelas }}</td>
                            <td>{{ $anggota->users->nis }}</td>
                            <td>{{ $anggota->users->name }}</td>
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
