<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaAbsensiController extends Controller
{
    public function getAbsen(Request $request, string $guru_id, string $nama_kelompok = null, int $hari = 0)
    {
        try {
            $kelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? ($kelompok[0] ?? '!kelompok');

            $absen = Kelompok::with([
                'anggota',
                'dudi' => function ($query) {
                    $query->select(['id', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
                }
            ])->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok)->first();

            if(!$absen){
                $absen = (object)[
                    'anggota' => collect([['user_id' => null]]),
                    'dudi' => []
                ];
            }

            $absensi = Absensi::with('user')->whereIn('user_id', $absen->anggota->pluck('user_id'))->whereDate('created_at', today()->subDays($hari))->get();

            return response()->json(['success' => true, 'data' => $absensi, 'kelompok_ini' => $namaKelompok, 'kelompok' => $kelompok, 'hari' => $hari, 'dudi' => $absen->dudi], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"], 500);
        }
    }

    public function absenReject(string $guru_id, string $nama_kelompok = null)
    {
        try {
            $listKelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? ($listKelompok[0] ?? '!kelompok');

            $kelompok = Kelompok::with(['anggota'])->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok)->first();

            $userAbsen = Absensi::whereDate('created_at', today())
                ->where('status', '!=', '6')
                ->whereIn('user_id', $kelompok->anggota->pluck('user_id'))
                ->pluck('user_id');

            $userBelumAbsen = $kelompok->anggota->pluck('user_id')->diff($userAbsen);

            $users = User::whereIn('id', $userBelumAbsen)->get();

            return response()->json(['success' => true, 'data' => $users, 'kelompok' => $listKelompok, 'kelompok_ini' => $namaKelompok]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"]);
        }
    }
}
