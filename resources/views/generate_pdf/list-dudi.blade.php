<div style="padding: 20px;">
    <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">Data Tempat PKL</div>
    <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">{{ $jurusan->jurusan }} SMKN 1 MEJAYAN</div>
    <div style="font-size: 18px; font-weight: bold;">THN. {{ date('Y') }}</div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">No</th>
                <th style="border: 1px solid black; padding: 8px;">Nama DuDi</th>
                <th style="border: 1px solid black; padding: 8px;">Pembimbing DuDi/ <br> Owner</th>
                <th style="border: 1px solid black; padding: 8px;">No Telp/WA - Email</th>
                <th style="border: 1px solid black; padding: 8px;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dudi as $i => $item)
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">{{ ++$i }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $item->nama }}</td>
                    <td style="border: 1px solid black; padding: 8px;">{{ $item->pemimpin }}</td>
                    <td style="border: 1px solid black; padding: 8px;">
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
                    <td style="border: 1px solid black; padding: 8px; white-space: initial; width: 35%;">{{ $item->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
