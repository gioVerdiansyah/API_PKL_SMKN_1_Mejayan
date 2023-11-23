<?php

namespace App\Http\Controllers\Api;

use Geocoder\Laravel\Facades\Geocoder;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenRequest;
use App\Models\Absensi;
use App\Models\User;
use Geocoder\Query\GeocodeQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function absen(AbsenRequest $request)
    {
        $user = User::with(['detailUser.detailPkl', 'detailUser.detailPkl.jamPkl'])->where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User tidak ditemukan'], 404);
        }

        $coorUser = ['latitude' => $request->lat, 'longitude' => $request->lon];
        $officeCoordinates = explode(', ', $user['detailUser']['detailPkl']['koordinat']);
        $officeCoordinates = ['latitude' => $officeCoordinates[0], 'longitude' => $officeCoordinates[1]];

        $jarak = $this->hitungJarak($coorUser, $officeCoordinates);

        $jarakBatas = 100;

        if ($jarak <= $jarakBatas) {
            $user_id = $user->id;
            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            $absenSudahAda = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())
                ->exists();

            if ($absenSudahAda) {
                return response()->json(['absen' => ['success' => false, 'message' => 'Anda sudah absen!']]);
            }

            $jamMasuk = $user['detailUser']['detailPkl']['jamPkl']["$hariIni"];
            $jamMasuk = explode(" - ", $jamMasuk)[0];
            $jamMasukTimestamp = strtotime($jamMasuk);
            $jamSekarangTimestamp = strtotime($now->format('H:i'));

            $selisihSatuJam = 3600;

            if ($jamSekarangTimestamp >= ($jamMasukTimestamp - $selisihSatuJam)) {
                if ($jamSekarangTimestamp > $jamMasukTimestamp) {
                    Absensi::create([
                        'user_id' => $user_id,
                        'status' => 2,
                    ]);
                    return response()->json(['absen' => ['success' => true, 'status' => 2, 'message' => 'Anda telat absen!']]);
                } else {
                    if ($request->wfh == '1') {
                        Absensi::create([
                            'user_id' => $user_id,
                            'status' => 4,
                        ]);
                        return response()->json(['absen' => ['success' => true, 'status' => 4, 'message' => 'Berhasil absen WFH!']]);
                    }
                    Absensi::create([
                        'user_id' => $user_id,
                        'status' => 1,
                    ]);
                    return response()->json(['absen' => ['success' => true, 'status' => 1, 'message' => 'Berhasil absen tepat waktu!']]);
                }
            }else{
                return response()->json(['absen' => ['success' => false, 'message' => 'Absen di mulai 1 jam sebelum jam masuk!']]);
            }
        } else {
            return response()->json(['absen' => ['success' => false, 'message' => 'Anda harus berada di kantor untuk melakukan absen']]);
        }
    }

    private function hitungJarak($coord1, $coord2)
    {
        $lat1 = deg2rad($coord1['latitude']);
        $lon1 = deg2rad($coord1['longitude']);
        $lat2 = deg2rad($coord2['latitude']);
        $lon2 = deg2rad($coord2['longitude']);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $radius = 6371;

        $distance = $radius * $c;

        return $distance * 1000;
    }
}
