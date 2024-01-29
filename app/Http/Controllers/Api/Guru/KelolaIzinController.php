<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KelolaIzinController extends Controller
{
    public function getIzin(string $guru_id, string $nama_kelompok = null, $status = '0')
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

            $izin = Izin::latest()->with('user')->whereIn('user_id', $kelompok->anggota->pluck('user_id'));

            if ($status !== '0') {
                $izin = $izin->where('status', $status);
            }

            $izin = $izin->paginate(1);

            return response()->json(['success' => true, 'data' => $izin, 'kelompok' => $listKelompok, 'kelompok_ini' => $namaKelompok, 'status' => $status]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Ada kesalahaan server"]);
        }
    }

    public function izinAgreement(Request $request)
    {
        try {
            DB::beginTransaction();
            $izin = Izin::where('id', $request->izin_id)->first();

            if (!$izin) {
                return response()->json(['success' => false, 'message' => 'ID izin tidak ditemukan']);
            }

            $izin->status = "{$request->status}";
            if ($request->has('keterangan')) {
                $izin->comment_guru = $request->keterangan;
            }
            $izin->save();

            $jumlahIzin = intval(Carbon::parse($izin->awal_izin)->diffInDays(Carbon::parse($izin->akhir_izin)));
            $user = User::where('id', $izin->user_id)->first();
            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            if($request->status == 1 && $jumlahIzin > 0){
                for($i = 1; $i <= $jumlahIzin; $i++){
                    $absensi = new Absensi;
                    $absensi->user_id = $izin->user_id;
                    $absensi->status = '6';
                    $absensi->datang = date('Y-m-d') . ' ' . explode(' - ', $user->{$hariIni})[0];
                    $absensi->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "Izin berhasil di " . (($request->status == 1) ? 'setujui' : 'tolak')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e]);
        }
    }

    public function tolakPaksaIzin(Request $request)
    {
        try {
            DB::beginTransaction();
            $izin = Izin::where('id', $request->izin_id)->first();

            if (!$izin) {
                return response()->json(['success' => false, 'message' => "ID Izin tidak ditemukan!!!"]);
            }

            $absen = Absensi::where('user_id', $izin->user_id)->whereDate('created_at', $izin->created_at)->first();
            $absen->status = 3;
            $absen->save();

            if (Storage::exists($izin->bukti)) {
                Storage::delete($izin->bukti);
            }

            $izin->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => "Berhasil me-nolak paksa izin!"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "Error: $e"]);
        }
    }
}
