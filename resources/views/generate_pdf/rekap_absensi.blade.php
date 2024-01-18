<style>
    @page {
        size: landscape;
    }
</style>
<div style="margin: 0;">
    <div style="margin-bottom: 10px;">
        <h3 style="margin: 5px 0;font-family: sans-serif;font-weight: 500">DAFTAR HADIR</h3>
        <h3 style="margin: 5px 0;font-family: sans-serif;font-weight: 500">PESERTA PRAKTIK KERJA LAPANGAN (PKL) SMKN 1
            MEJAYAN</h3>
        <h3 style="margin: 5px 0;font-family: sans-serif;font-weight: 500; text-transform: uppercase">DI
            {{ $kelompok->dudi->nama }}</h3>
        <h3 style="margin: 5px 0;font-family: sans-serif;font-weight: 500; text-transform: uppercase">BULAN:
            {{ $absensiBulan }}</h3>
    </div>
    <div style="display: flex; flex-direction: row;width: 10%">
        <!-- Header Section -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        {{ explode(' - ', $kelompok->dudi->senin)[0] ?? '08:00' }}
                    </th>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">tanggal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Date Rows -->
                @foreach ($absensi as $data)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- User Data Section -->
        @foreach ($listUser as $i => $data)
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr>
                        <th colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            {{ $data->name }}
                        </th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Datang</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Terlambat</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- User-specific Data Rows -->
                    @foreach ($absensi as $absenData)
                        @if ($absenData->user_id == $data->id)
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                    {{ \Carbon\Carbon::parse($absenData->datang)->format('H:i') }}
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                    {{ \Carbon\Carbon::parse($absenData->telat)->format('H:i') }}
                                </td>
                                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                    {{ \Carbon\Carbon::parse($absenData->pulang)->format('H:i') }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>



    {{-- <script>
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

</script> --}}
