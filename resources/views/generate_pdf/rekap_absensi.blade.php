<div style="margin: 0;">
    <h2 style="text-align: center;">Rekap Absensi PKL Jurusan {{ $guru->jurusan->jurusan }}</h2>
    <div style="margin-bottom: 10px;">
        <p style="margin: 0"><span style="font-weight: bold;">Pengurus PKL:</span> {{ $guru->nama }} {{ $guru->gelar }}</p>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">#</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Tanggal</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Datang</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Tipe Kehadiran</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Pulang</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataAbsensi as $i => $data)
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px;">{{ ++$i }}</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center">{{ \Carbon\Carbon::parse($data->created_at)->format('d M') }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center">{{ \Carbon\Carbon::parse($data->datang)->format('d-m-Y H:i') }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center">
                        @php
                            switch ($data->status) {
                                case '1':
                                    echo "Hadir";
                                    break;
                                case '2':
                                    echo "Hadir/telat";
                                    break;
                                case '4':
                                    echo "WFH";
                                    break;
                                case '5':
                                    echo "WFH/telat";
                                    break;
                                default:
                                    echo "Alpha";
                                    break;
                            }
                        @endphp
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center">{{
                        (!$data->pulang) ? " " : \Carbon\Carbon::parse($data->pulang)->format('d-m-Y H:i')
                    }}</td>
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
