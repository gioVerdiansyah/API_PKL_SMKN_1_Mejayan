<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenRequest;
use App\Http\Requests\IzinStoreRequest;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function absen(AbsenRequest $request)
    {
        try {
            $user = User::with(['detailUser.detailPkl', 'detailUser.detailPkl.jamPkl'])->where('id', $request->user_id)->first();
            $user_id = $user->id;

            if (!$user) {
                return response()->json(['absen' => ['success' => false, 'message' => 'User tidak ditemukan']], 404);
            }

            $absenSudahAda = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())->where('status', '!=', '5')
                ->exists();

            if ($absenSudahAda) {
                return response()->json(['absen' => ['success' => false, 'message' => 'Anda sudah absen!']]);
            }

            $absenIzin = Izin::where('user_id', $user_id)->whereDate('created_at', today())->exists();
            if ($absenIzin) {
                return response()->json(['absen' => ['success' => false, 'message' => "Anda tidak bisa absen karena anda sudah melakukan izin"]]);
            }

            if ($request->wfh == '1') {
                Absensi::create([
                    'user_id' => $user_id,
                    'status' => 4,
                ]);
                return response()->json(['absen' => ['success' => true, 'status' => 4, 'message' => 'Berhasil absen WFH!']]);
            }

            $coorUser = ['latitude' => $request->lat, 'longitude' => $request->lon];
            $officeCoordinates = explode(', ', $user['detailUser']['detailPkl']['koordinat']);
            $officeCoordinates = ['latitude' => $officeCoordinates[0], 'longitude' => $officeCoordinates[1]];

            $jarak = $this->hitungJarak($coorUser, $officeCoordinates);

            $jarakBatas = 100;

            if ($jarak <= $jarakBatas) {
                $now = Carbon::now()->locale('id');
                $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

                $jamMasuk = $user['detailUser']['detailPkl']['jamPkl']["$hariIni"];
                if (is_null($jamMasuk)) {
                    return response()->json(["absen" => ["success" => false, "message" => "Anda tidak dapat absen pada hari $hariIni"]]);
                }
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
                        Absensi::create([
                            'user_id' => $user_id,
                            'status' => 1,
                        ]);
                        return response()->json(['absen' => ['success' => true, 'status' => 1, 'message' => 'Berhasil absen tepat waktu!']]);
                    }
                } else {
                    return response()->json(['absen' => ['success' => false, 'message' => 'Absen di mulai 1 jam sebelum jam masuk!']]);
                }
            } else {
                return response()->json(['absen' => ['success' => false, 'message' => 'Anda harus berada di kantor untuk melakukan absen']]);
            }
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, "message" => "Error: {$e->getMessage()}"]]);
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

    public function pulang(AbsenRequest $request)
    {
        try {
            $user = User::with(['detailUser.detailPkl', 'detailUser.detailPkl.jamPkl'])->where('id', $request->user_id)->first();

            if (!$user) {
                return response()->json(['absen' => ['success' => false, 'message' => 'User tidak ditemukan']], 404);
            }

            $coorUser = ['latitude' => $request->lat, 'longitude' => $request->lon];
            $officeCoordinates = explode(', ', $user['detailUser']['detailPkl']['koordinat']);
            $officeCoordinates = ['latitude' => $officeCoordinates[0], 'longitude' => $officeCoordinates[1]];

            $jarak = $this->hitungJarak($coorUser, $officeCoordinates);

            $jarakBatas = 100;

            if ($jarak <= $jarakBatas) {
                $user_id = $user->id;

                $absenPulang = Absensi::where('user_id', $user_id)
                    ->whereDate('created_at', today())
                    ->where('status', 5)
                    ->exists();

                if ($absenPulang) {
                    return response()->json(['absen' => ['success' => false, 'message' => 'Anda sudah absen pulang!']]);
                }

                $absenHadir = Absensi::where('user_id', $user_id)
                    ->whereDate('created_at', today())
                    ->whereIn('status', [1, 2, 4])
                    ->exists();

                if (!$absenHadir) {
                    return response()->json(['absen' => ['success' => false, 'message' => 'Anda belum absen pada hari ini!']]);
                }

                $absenCutiIzinSakit = Izin::where('user_id', $user_id)
                    ->whereDate('created_at', today())
                    ->exists();

                if ($absenCutiIzinSakit) {
                    return response()->json(['absen' => ['success' => false, 'message' => 'Anda tidak bisa absen pulang karena [\'Cuti\', \'Izin\', \'Sakit\']!']]);
                }

                $absenAlpha = Absensi::where('user_id', $user_id)
                    ->whereDate('created_at', today())
                    ->where('status', 3)
                    ->exists();

                if ($absenAlpha) {
                    return response()->json(['absen' => ['success' => false, 'message' => 'Anda tidak bisa absen pulang karena anda dinyatakan alpha!']]);
                }

                Absensi::create([
                    'user_id' => $user_id,
                    'status' => 5,
                ]);

                return response()->json(['absen' => ['success' => true, 'status' => 1, 'message' => 'Berhasil absen pulang!']]);

            } else {
                return response()->json(['absen' => ['success' => false, 'message' => 'Anda harus berada di kantor untuk melakukan absen']]);
            }
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, "message" => "Error: {$e->getMessage()}"]]);
        }
    }

    public function izin(IzinStoreRequest $request)
    {
        try {
            $user = User::where('name', $request->name)->first();

            if (!$user) {
                return response()->json(['izin' => ['success' => false, 'message' => 'Nama siswa tidak ditemukan']]);
            }

            $sudahIzin = Izin::where('user_id', $user->id)->whereDate('created_at', today())->exists();
            if ($sudahIzin) {
                return response()->json(['izin' => ['success' => false, "message" => "Anda sudah izin pada hari ini"]]);
            }

            $izin = new Izin;
            $izin->user_id = $user->id;
            $izin->tipe_izin = $request->tipe_izin;
            $izin->alasan = $request->alasan;
            $izin->awal_izin = Carbon::parse($request->awal_izin);
            $izin->akhir_izin = Carbon::parse($request->akhir_izin);

            if(!$request->hasFile("bukti")){
                return response()->json(["izin"=> ["success"=> false, "message" => "Foto Bukti tidak ditemukan!"]]);
            }

            $nameFile = $request->file('bukti')->hashName();
            $path = $request->file('bukti')->storeAs('bukti_izin', $nameFile);

            $izin->bukti = $path;
            $izin->save();

            return response()->json(['izin' => ['success' => true, 'message' => "Berhasil izin pada hari ini"]]);

        } catch (\Exception $e) {
            return response()->json(["izin" => ["success" => false, 'message' => "Error: {$e->getMessage()}"]]);
        }
    }

    public function izinGet(string $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return response()->json(['izin' => ['success' => false, 'message' => 'User Id tidak di temukan']]);
            }
            $dataIzin = Izin::where('user_id', $user->id)->get();

            return response()->json(['izin' => ['success' => true, 'message' => 'Berhasil mendapatkan data', 'data' => $dataIzin->toArray()]]);
        } catch (\Exception $e) {
            return response()->json(['izin' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]]);
        }
    }
}
