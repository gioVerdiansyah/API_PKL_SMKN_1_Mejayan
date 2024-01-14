<style>
    @page { size: landscape; }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 2px solid black;
        padding: 8px;
        text-align: left;
        font-size: 10px;
    }
    .p-3 {
        padding: 1rem!important;
    }
    .header {
        text-align: center;
    }
    h4 {
        margin: 0;
    }
    .mt-3 {
        margin-top: 1rem;
    }
    .table-bordered {
        border: 2px solid black;
    }
    .table-warning th {
        background-color: #ffc107;
    }
    .table-light th,
    .table-light td,
    .table-secondary th,
    .table-secondary td {
        background-color: #f8f9fa;
    }
    .table-light tr:nth-child(even) {
        background-color: #ffffff;
    }
    .table-secondary tr:nth-child(even) {
        background-color: #dfdfdf;
    }
    .table-dark {
        background-color: #343a40;
        color: white;
    }
</style>
<div style="padding: 1rem!important;">
    <div style="text-align: center;text-transform: uppercase">
        <h4 style="margin: 0;">DATA PESERTA PRAKTIK KERJA LAPANGAN</h4>
        <h4 style="margin: 0;">JURUSAN {{ $jurusan->full_name }}</h4>
        <h4 style="margin: 0;">SMK NEGRI 1 MEJAYAN</h4>
        <h4 style="margin: 0;">TAHUN PEMBELAJARAN {{ date('Y') }}/{{ date('Y', strtotime('+1 year')) }}</h4>
    </div>
    <table style="border-collapse: collapse; width: 100%;" class="table-bordered mt-3">
        <thead>
            <tr style="background-color: #ffc107;">
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
            <tr style="background-color: #f8f9fa;">
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
                @php $firstAnggota = $item->anggota->first(); $i++; @endphp
                <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa;' : 'background-color: #e9ecef;' }}">
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
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa;' : 'background-color: #e9ecef;' }}">
                            @php ++$i; @endphp
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
                <td colspan="9" style="background-color: #343a40; color: white;"></td>
            @endforeach
        </tbody>
    </table>
</div>
