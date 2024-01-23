<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaAbsensiController extends Controller
{
    public function getAbsen(Request $request, string $guru_id, string $nama_kelompok = null, int $hari = 0)
    {
        try {
            $kelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? ($kelompok[0] ?? '!kelompok');

            $absen = Kelompok::with([
                'anggota',
                'dudi'
            ])->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok)->first();

            if (!$absen) {
                $absen = (object) [
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

    public function getAnggota(string $guru_id)
    {
        try {
            $kelompok = Kelompok::with('anggota')->where('guru_id', $guru_id)->get();

            if ($kelompok->isEmpty()) {
                return response()->json(['success' => false, 'message' => "ID Guru tidak ada di dalam Kelompok!"]);
            }

            $user_id = $kelompok->pluck('anggota.*.user_id')->flatten();
            $anggota = User::select('name')->whereIn('id', $user_id)->pluck('name');

            return response()->json(['success' => true, 'data' => $anggota]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: $e"]);
        }
    }

    public function absenTrouble(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('name', $request->nama_siswa)->first();

            if (!$user) {
                return response()->json(['success' => false, 'message' => "Nama tidak ditemukan!"]);
            }

            $absen = Absensi::where('user_id', $user->id)->whereDate('created_at', today())->first();

            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            $dateObj = new DateTime();
            $dateObj->setTimestamp(strtotime(explode(' - ', $user->{$hariIni})[0]));

            $tipeKehadiran = 1;

            switch ($request->tipe_kehadiran) {
                case 'WFH':
                    $tipeKehadiran = 4;
                    break;
                case 'Cuti':
                    $tipeKehadiran = 7;
                    break;
                default:
                    $tipeKehadiran = 1;
                    break;
            }

            if (!$absen) {
                $absensi = new Absensi;
                $absensi->user_id = $user->id;
                $absensi->status = $tipeKehadiran;
                $absensi->datang = $dateObj->format('Y-m-d H:i:s');
                $absensi->save();

                DB::commit();
                return response()->json(['success' => true, 'message' => "Berhasil membuat absensi siswa {$request->nama_siswa} menjadi {$request->tipe_kehadiran}"]);
            }

            return response()->json(['success' => false, 'message' => "Siswa {$request->nama_siswa} sudah melakukan absensi!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"]);
        }
    }
}
