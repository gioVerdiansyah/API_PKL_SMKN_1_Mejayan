<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaAbsensiController extends Controller
{
    public function getAbsen(Request $request, string $guru_id, string $nama_kelompok = null)
    {
        try {
            $kelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? $kelompok[0];

            // $absen = Absensi::with([
            //     'user.anggota.kelompok' => function ($query) use ($guru_id, $namaKelompok) {
            //         $query->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok);
            //     }
            // ])->whereDate('created_at', today())->whereNot('status', 5)->paginate(2);

            $absen = Absensi::with(['user.anggota.kelompok' => function ($query) use ($guru_id, $namaKelompok) {
                $query->with(['guru' => function ($subQuery) use ($guru_id) {
                    $subQuery->where('id', $guru_id);
                }])->where('nama_kelompok', $namaKelompok);
            }])->paginate(10);

            return response()->json(['success' => true, 'data' => $absen, 'kelompok' => $kelompok], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"], 500);
        }
    }
    public function getAbsenPulang(Request $request, string $guru_id)
    {
        try {
            $absen = Absensi::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                }
            ])->whereDate('created_at', today())->where('status', 5)->paginate(1);

            return response()->json(['success' => true, 'data' => $absen], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"], 500);
        }
    }

    public function absenReject(string $guru_id, string $nama_kelompok = null)
    {
        try {
            $user_id = [];
            $kelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? $kelompok[0];
            $absen = Absensi::with([
                'user.anggota.kelompok' => function ($query) use ($guru_id, $namaKelompok) {
                    $query->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok);
                }
            ])->whereDate('created_at', today())->get();
            foreach ($absen as $item) {
                array_push($user_id, $item->user_id);
            }
            $user = User::whereNotIn('id', $user_id)->get();

            return response()->json(['id' => $user_id, 'success' => true, 'data' => $user]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Ada kesalahan server!"]);
        }
    }
}
