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
    <div style="display: flex; flex-direction: row;max-width: 100vw;">
        <table class="table">
            <thead>
                <tr>
                    <th class="border border-3 border-secondary p-2 text-center">Nama</th>
                    <th class="border border-3 border-secondary p-2 text-center">Kelas</th>
                    <th class="border border-3 border-secondary p-2 text-center">Hadir</th>
                    <th class="border border-3 border-secondary p-2 text-center">Telat</th>
                    <th class="border border-3 border-secondary p-2 text-center">Izin</th>
                    <th class="border border-3 border-secondary p-2 text-center">WFH</th>
                    <th class="border border-3 border-secondary p-2 text-center">Sakit</th>
                    <th class="border border-3 border-secondary p-2 text-center">Dispen</th>
                    <th class="border border-3 border-secondary p-2 text-center">Cuti</th>
                </tr>
            </thead>
            <tbody>
                <!-- User Rows -->
                @foreach ($absensi->groupBy('user_id') as $userId => $userAbsensi)
                    <tr>
                        <td  class="border border-3 border-secondary p-2 ps-3">{{ $userAbsensi->first()->user->name }}</td>
                        <td  class="border border-3 border-secondary p-2 ps-3">{{ $userAbsensi->first()->user->kelas->kelas }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ $userAbsensi->whereIn('status', ['1', '2', '4', '5'])->count() }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ $userAbsensi->whereIn('status', ['2', '5'])->count() }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ $userAbsensi->where('status', '6')->count() }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ $userAbsensi->whereIn('status', ['4', '5'])->count() }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ \App\Models\Izin::where('user_id', $userId)->where('tipe_izin', 'Sakit')->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$bulannya])->count() }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ \App\Models\Izin::where('user_id', $userId)->where('tipe_izin', 'Dispensasi')->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$bulannya])->count() }}</td>
                        <td  class="border border-3 border-secondary p-2 text-center">{{ $userAbsensi->where('status', '7')->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="ps-5 pt-3 d-flex flex-column justify-content-start">
            <h3 class="my-1 fs-5">Pemimpin/Pengurus DuDi</h3>
            <div style="width: 100px;height: 70px;"></div>
            <h3 class="my-1 fs-5">{{ $kelompok->dudi->pemimpin }}</h3>
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
