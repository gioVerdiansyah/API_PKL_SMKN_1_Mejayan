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
        <h3 style="margin: 5px 0;font-family: sans-serif;font-weight: 500">DI KAHFIDLKFNDJKFN</h3>
        <h3 style="margin: 5px 0;font-family: sans-serif;font-weight: 500">BULAN: JULI 2024</h3>
    </div>
    <div style="display: flex;flex-direction: row">
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        @php
                            echo explode(' - ', $dataAbsensi[0]->user->detailUser->detailPkl->jamPkl->senin)[0] ?? '08:00';
                        @endphp
                    </th>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataAbsensi as $data)
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">
                            {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @foreach ($dataAbsensi as $i => $data)
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr>
                        <th colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            {{ $data->user->name }}</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Datang</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Terlambat</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center">
                            {{ \Carbon\Carbon::parse($data->datang)->format('H:i') }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center">
                            @php
                                $currentDate = date('Y-m-d');
                                $arrivalTime = new DateTime("$currentDate 08:30:00");
                                $expectedArrival = new DateTime("$currentDate 08:00:00");

                                $tardiness = $arrivalTime->diff($expectedArrival);

                                echo $tardiness->format('%H:%I');
                            @endphp
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center">
                            {{ \Carbon\Carbon::parse($data->pulang)->format('H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>
</div>

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
