<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kakomli;
use App\Models\Kelas;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function dashboard()
    {
        $kelompok = Kelompok::count();
        $user = User::count();
        $dudi = Dudi::count();
        $guru = Guru::count();
        return view('admin.dashboard', compact('kelompok', 'user', 'dudi', 'guru'));
    }

    public function dataKakomli()
    {
        $kakomli = Kakomli::whereNot('email', config('app.admin_email'))->paginate(10);
        return view('admin.kakomli.index', compact('kakomli'));
    }

    public function synchronization()
    {
        return view('admin.synchronizationData');
    }
    public function synchronizationdata()
    {
        try {
            $responseJurusan = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'jurusan');
            $dataJurusan = json_decode($responseJurusan->body());

            DB::beginTransaction();

            $statistics = [
                'jurusan' => [
                    'create' => 0,
                    'update' => 0,
                ],
                'kelas' => [
                    'create' => 0,
                    'update' => 0,
                ],
            ];

            $responseJurusan = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'jurusan');
            $dataJurusan = json_decode($responseJurusan->body());

            foreach ($dataJurusan as $item) {
                $existingJurusan = Jurusan::find($item->id);

                if ($existingJurusan && $existingJurusan->updated_at != $item->updated_at) {
                    $existingJurusan->jurusan = $item->jurusan;
                    $existingJurusan->full_name = $item->full_name;
                    $existingJurusan->gambar = config('app.admin_url') . $item->gambar;
                    $existingJurusan->created_at = $item->created_at;
                    $existingJurusan->updated_at = $item->updated_at;
                    $existingJurusan->save();

                    $statistics['jurusan']['update']++;
                } elseif (!$existingJurusan) {
                    $newJurusan = new Jurusan();
                    $newJurusan->id = $item->id;
                    $newJurusan->jurusan = $item->jurusan;
                    $newJurusan->full_name = $item->full_name;
                    $newJurusan->gambar = config('app.admin_url') . $item->gambar;
                    $newJurusan->created_at = $item->created_at;
                    $newJurusan->updated_at = $item->updated_at;
                    $newJurusan->save();

                    $statistics['jurusan']['create']++;
                }
            }

            $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'kelas');
            $dataKelas = json_decode($responseKelas->body());

            foreach ($dataKelas as $item) {
                $existingKelas = Kelas::find($item->id);

                if ($existingKelas && $existingKelas->updated_at != $item->updated_at) {
                    $existingKelas->kelas = $item->tingkatan . ' ' . $item->kelas;
                    $existingKelas->created_at = Carbon::parse($item->created_at);
                    $existingKelas->updated_at = Carbon::parse($item->updated_at);
                    $existingKelas->save();

                    $statistics['kelas']['update']++;
                } elseif (!$existingKelas) {
                    $newKelas = new Kelas();
                    $newKelas->id = $item->id;
                    $newKelas->kelas = $item->tingkatan . ' ' . $item->kelas;
                    $newKelas->created_at = Carbon::parse($item->created_at);
                    $newKelas->updated_at = Carbon::parse($item->updated_at);
                    $newKelas->save();

                    $statistics['kelas']['create']++;
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'data' => $statistics, 'message' => "Berhasil mendapatkan data"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "Ada kesalahan saat mendapatkan data!", 'error' => $e->getMessage()]);
        }
    }

    public function authorizationQR()
    {
        $response = Http::withHeaders([
            'x-api-key' => config('app.api_key_bot_wa')
        ])->get(config('app.app_url_bot_wa') . '/start-session', [
                    'session' => 'PKL_SMKN1Mejayan',
                    'scan' => true
                ]);

        return view('admin.authorizationQR', compact('response'));
    }
}
