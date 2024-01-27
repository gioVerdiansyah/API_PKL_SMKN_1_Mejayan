<style>
    @page {
        size: landscape;
    }
</style>

<div style="margin: 0;">
    <h1 style="text-align: center;text-transform: uppercase">Rekap Jurnal PKL</h1>
    <div style="margin-bottom: 10px;">
        <p style="margin: 0"><span style="font-weight: bold;">Nama:</span> {{ $user->name }}</p>
        <p style="margin: 0"><span style="font-weight: bold;">Absen:</span> {{ $user->absen }}</p>
        <p style="margin: 0"><span style="font-weight: bold;">Kelas:</span> {{ $user->kelas->kelas }}</p>
        <p style="margin: 0"><span style="font-weight: bold;">Tempat Dudi:</span> {{ $kelompok->dudi->nama }}</p>
        <p style="margin: 0"><span style="font-weight: bold;">Pembimbing:</span> {{ $kelompok->guru->nama }}</p>
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
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        {{ \Carbon\Carbon::parse($data->created_at)->locale('id')->isoFormat('dddd, DD-MM-YYYY') }}
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px;">
                        @if (is_null($data->bukti))
                            No Image
                        @else
                            @if ($isRekap)
                                <img src="{{ url('storage/' . $data->bukti) }}"
                                    alt="Foto Jurnal siswa {{ $user->name }} ke {{ $i }}"
                                    style="width: 100px; height: auto;">
                            @else
                                <img src="storage/{{ $data->bukti }}"
                                    alt="Foto Jurnal siswa {{ $user->name }} ke {{ $i }}"
                                    style="width: 100px; height: auto;">
                            @endif
                        @endif
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px;">
                        <p style="word-wrap: break-word; white-space: pre-line;">{{ $data->kegiatan }}</p>
                    </td>
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
    <div style="margin-top: 20px">
        <h3 class="my-1 fs-5">Pemimpin/Pengurus DuDi</h3>
        <div style="width: 100px;height: 70px;"></div>
        <h3>{{ $kelompok->dudi->pemimpin }}</h3>
    </div>
</div>

@if ($isRekap)
    <script>
        window.addEventListener('load', function() {
            window.print({
                landscape: true,
                headers: false,
                options: false
            });
            window.onafterprint = function() {
                alert("tekan ctrl + p untuk print lagi");
            }
        });
    </script>
@endif
