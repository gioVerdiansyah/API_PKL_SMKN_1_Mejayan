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
                <th scope="col" style="text-align: center">KELOMPOK</th>
                <th scope="col" style="text-align: center">KELAS</th>
                <th scope="col" style="text-align: center">NOMOR INDUK</th>
                <th scope="col" style="text-align: center">NAMA SISWA</th>
                <th scope="col" style="text-align: center">DUDI TEMPAT PRAKERIN</th>
                <th scope="col" style="text-align: center">NAMA PIMPINAN DUDI</th>
                <th scope="col" style="text-align: center">NO. TELP/HP DUDI</th>
                <th scope="col" style="text-align: center">ALAMAT DUDI</th>
                <th scope="col" style="text-align: center">PEMBIMBING</th>
            </tr>
            <tr style="background-color: #f8f9fa;">
                <th scope="col" style="text-align: center">1</th>
                <th scope="col" style="text-align: center">2</th>
                <th scope="col" style="text-align: center">3</th>
                <th scope="col" style="text-align: center">4</th>
                <th scope="col" style="text-align: center">5</th>
                <th scope="col" style="text-align: center">6</th>
                <th scope="col" style="text-align: center">7</th>
                <th scope="col" style="text-align: center">8</th>
                <th scope="col" style="text-align: center">9</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelompok as $i => $item)
                @php $firstAnggota = $item->anggota->first(); $i++; @endphp
                <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa;' : 'background-color: #e9ecef;' }}">
                    <td rowspan="{{ count($item->anggota) }}" style="text-align: center; vertical-align: middle">{{ $item->nama_kelompok }}</td>
                    <td>{{ $firstAnggota->users->kelas->kelas }}</td>
                    <td>{{ $firstAnggota->users->nis }}</td>
                    <td>{{ $firstAnggota->users->name }}</td>
                    <td rowspan="{{ count($item->anggota) }}" style="text-align: center; vertical-align: middle">{{ $item->dudi->nama }}</td>
                    <td rowspan="{{ count($item->anggota) }}" style="text-align: center; vertical-align: middle">{{ $item->dudi->pemimpin }}</td>
                    <td rowspan="{{ count($item->anggota) }}" style="text-align: center; vertical-align: middle">{{ $item->dudi->no_telp }}</td>
                    <td rowspan="{{ count($item->anggota) }}" style="text-align: center; vertical-align: middle">{{ $item->dudi->alamat }}</td>
                    <td rowspan="{{ count($item->anggota) }}" style="text-align: center; vertical-align: middle">{{ $item->guru->nama }} {{ $item->guru->gelar }}</td>
                </tr>
                @foreach ($item->anggota as $j => $anggota)
                    @if ($j > 0)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa;' : 'background-color: #e9ecef;' }}">
                            @php ++$i; @endphp
                            <td>{{ $anggota->users->kelas->kelas }}</td>
                            <td>{{ $anggota->users->nis }}</td>
                            <td>{{ $anggota->users->name }}</td>
                        </tr>
                    @endif
                @endforeach
                <td colspan="9" style="background-color: #343a40; color: white;"></td>
            @endforeach
        </tbody>
    </table>
</div>
