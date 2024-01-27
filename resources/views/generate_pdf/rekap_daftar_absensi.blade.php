<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<style>
    @page {
        size: landscape;
    }
</style>
@php
    $sameDate = [];
@endphp
<div class="m-3">
    <div style="margin-bottom: 10px;">
        <h3 class="my-1 fs-5">REKAP KEHADIRAN</h3>
        <h3 class="my-1 fs-5">PESERTA PRAKTIK KERJA LAPANGAN (PKL) SMKN 1
            MEJAYAN</h3>
        <h3 class="my-1 fs-5 text-uppercase">DI
            {{ $kelompok->dudi->nama }}</h3>
        <h3 class="my-1 fs-5 text-uppercase">BULAN:
            {{ $absensiBulan }}</h3>
    </div>
    @php
        $usersChunks = array_chunk($listUser->toArray(), 5);
    @endphp

    @foreach ($usersChunks as $usersChunk)
        <div class="d-flex flex-row" style="width: min-content">
            <!-- Header Section -->
            <table class="table">
                <thead>
                    <tr>
                        <th rowspan="2" class="border border-2 border-secondary text-center"
                            style="padding: 27px 8px;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Date Rows -->
                    @foreach ($absensi->pluck('created_at')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        })->unique() as $data)
                        @php
                            array_push($sameDate, $data);
                        @endphp
                        <tr>
                            <td class="border border-2 border-secondary border-secondary p-2 text-center">
                                {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- User Data Section -->
            @foreach ($usersChunk as $data)
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="4" class="border border-2 border-secondary p-2 text-center">
                                @php
                                    $maxLength = 30;
                                    $name = $data['name'];

                                    if (strlen($name) > $maxLength) {
                                        $words = explode(' ', $name);
                                        $lastWordIndex = count($words) - 1;

                                        if (strlen($words[$lastWordIndex]) > 1) {
                                            $words[$lastWordIndex] = strtoupper(substr($words[$lastWordIndex], 0, 1));
                                        }

                                        $truncatedName = implode(' ', $words);
                                        echo $truncatedName;
                                    } else {
                                        echo $name;
                                    }
                                @endphp
                            </th>
                        </tr>
                        <tr>
                            <th class="border border-2 border-secondary p-2 text-center">Datang</th>
                            <th class="border border-2 border-secondary p-2 text-center">Terlambat</th>
                            <th class="border border-2 border-secondary p-2 text-center">Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User-specific Data Rows -->
                        @foreach ($absensi as $j => $absenData)
                            @if ($absenData->user_id == $data['id'])
                                @if (in_array($absenData->status, ['1', '2', '4', '5']))
                                    <tr>
                                        <td class="border border-2 border-secondary p-2 text-center">
                                            {{ $absenData->datang !== null ? \Carbon\Carbon::parse($absenData->datang)->format('H:i') : '-' }}
                                        </td>
                                        <td class="border border-2 border-secondary p-2 text-center">
                                            {{ $absenData->telat !== null ? \Carbon\Carbon::parse($absenData->telat)->format('H:i') : '-' }}
                                        </td>
                                        <td class="border border-2 border-secondary p-2 text-center">
                                            {{ $absenData->pulang !== null ? \Carbon\Carbon::parse($absenData->pulang)->format('H:i') : '-' }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="3" class="border border-2 border-secondary p-2 text-center">
                                            @if ($absenData->status == '3')
                                                Alpha
                                            @elseif ($absenData->status == '6')
                                                Izin
                                            @elseif ($absenData->status == '7')
                                                Cuti
                                            @else
                                                Tidak Absen
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endforeach
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
