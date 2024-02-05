<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaJurnalController extends Controller
{
    public function getJurnal(string $guru_id, string $nama_kelompok = null, int $hari = 0, string $status = '0')
    {
        try {
            $listKelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? ($listKelompok[0] ?? '!kelompok');

            $kelompok = Kelompok::with(['anggota',])->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok)->first();

            if (!$kelompok) {
                $kelompok = (object) [
                    'anggota' => collect([['user_id' => null]]),
                    'dudi' => []
                ];
            }

            $jurnal = Jurnal::with('user')->where('status', '3')->whereIn('user_id', $kelompok->anggota->pluck('user_id'))->whereDate('created_at', today()->subDays($hari));

            if($status !== '0'){
                $jurnal->where('status', $status);
            }

            $jurnal = $jurnal->get();

            return response()->json(['success' => true, 'data' => $jurnal, 'kelompok_ini' => $namaKelompok, 'kelompok' => $listKelompok, 'hari' => $hari, 'status' => $status], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ada kesalahaan server!']);
        }
    }

    public function jurnalAgreement(Request $request)
    {
        try {
            DB::beginTransaction();
            $jurnal = Jurnal::where('id', $request->jurnal_id)->first();

            if (!$jurnal) {
                return response()->json(['success' => false, 'message' => 'ID jurnal tidak ditemukan']);
            }

            $jurnal->status = "{$request->status}";
            if ($request->has('keterangan')) {
                $jurnal->keterangan = $request->keterangan;
            }
            $jurnal->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => "Jurnal berhasil di " . (($request->status == 1) ? 'setujui' : 'tolak')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e]);
        }
    }

    public function jurnalReject(string $guru_id, string $nama_kelompok = null)
    {
        try {
            $listKelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? ($listKelompok[0] ?? '!kelompok');

            $kelompok = Kelompok::with(['anggota'])->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok)->first();

            $userJurnal = Jurnal::whereDate('created_at', today())
                ->whereIn('user_id', $kelompok->anggota->pluck('user_id'))
                ->pluck('user_id');

            $userBelumJurnal = $kelompok->anggota->pluck('user_id')->diff($userJurnal);

            $users = User::whereIn('id', $userBelumJurnal)->get();

            return response()->json(['success' => true, 'data' => $users]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Ada kesalahan server"]);
        }
    }
}
