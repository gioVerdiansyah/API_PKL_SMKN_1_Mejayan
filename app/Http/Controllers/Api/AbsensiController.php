<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenRequest;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function absen(AbsenRequest $request)
    {
        $user = $request->user_id;
        $now = Carbon::now()->locale('id');
        $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

        $absenSudahAda = Absensi::where('user_id', $user)
            ->whereDate('created_at', today())
            ->exists();

        if ($absenSudahAda) {
            return response()->json(['absen' => ['success' => false, 'message' => 'Anda sudah absen!']]);
        }

        $jamMasuk = User::with(['detailUser.detailPkl.jamPkl'])->where('id', $user)->first()['detailUser']['detailPkl']['jamPkl']["$hariIni"];
        $jamMasuk = explode(" - ", $jamMasuk)[0];

        if($request->wfh == '1') {
            Absensi::create([
                'user_id' => $user,
                'status' => 4,
            ]);
            return response()->json(['absen' => ['success' => true, 'status' => 4, 'message' => 'Berhasil absen WFH! ' . $request->wfh]]);
        }

        $jamSekarang = $now->format('H:i');
        if ($jamSekarang > $jamMasuk) {
            Absensi::create([
                'user_id' => $user,
                'status' => 2,
            ]);
            return response()->json(['absen' => ['success' => true, 'status' => 2, 'message' => 'Anda telat absen!']]);
        } else {
            Absensi::create([
                'user_id' => $user,
                'status' => 1,
            ]);
            return response()->json(['absen' => ['success' => true, 'status' => 1, 'message' => 'Berhasil absen tepat waktu!']]);
        }
    }
}
