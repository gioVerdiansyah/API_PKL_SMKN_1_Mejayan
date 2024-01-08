<div style="margin: 0;">
    <h1 style="text-align: center;">Rekap Jurnal</h1>
    <div style="margin-bottom: 10px;">
        <p style="margin: 0"><span style="font-weight: bold;">Nama:</span> {{ $user->name }}</p>
        <p style="margin: 0"><span style="font-weight: bold;">Absen:</span> {{ $user->detailUser->absen }}</p>
        <p style="margin: 0"><span style="font-weight: bold;">Kelas:</span> {{ $user->detailUser->kelas->kelas }}</p>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">#</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Tanggal</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Foto</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataJurnal as $i => $data)
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px;">{{ ++$i }}</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center">{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;"><img src="storage/{{ $data->bukti }}" alt="Foto Jurnal siswa {{ $user->name }} ke {{ $i }}" style="width: 100px; height: auto;"></td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $data->kegiatan }}</td>
                </tr>
            @empty
                <tr>
                    <th colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        <p style="margin: 0;">Tidak ada data jurnal...</p>
                    </th>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
