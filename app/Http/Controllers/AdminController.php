<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kakomli;
use App\Models\Kelas;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public function syncJurusan()
    {
        try {
            $responseJurusan = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'jurusan');
            $dataJurusan = json_decode($responseJurusan->body());

            DB::beginTransaction();

            $responseJurusan = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'jurusan');
            $dataJurusan = json_decode($responseJurusan->body());

            foreach ($dataJurusan as $item) {
                Jurusan::updateOrCreate(
                    ['id' => $item->id],
                    [
                        'jurusan' => $item->jurusan,
                        'full_name' => $item->full_name,
                        'gambar' => config('app.admin_url') . $item->gambar,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at
                    ]
                );
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Jurusan', 'next_url' => route('admin.synchronization-data-kelas')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Jurusan', 'error' => $e->getMessage()]);
        }
    }

    public function syncKelas()
    {
        try {
            DB::beginTransaction();

            $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'kelas');
            $dataKelas = json_decode($responseKelas->body());

            foreach ($dataKelas as $item) {
                Kelas::updateOrCreate(
                    ['id' => $item->id],
                    [
                        'kelas' => $item->tingkatan . ' ' . $item->kelas,
                        'created_at' => Carbon::parse($item->created_at),
                        'updated_at' => Carbon::parse($item->updated_at)
                    ]
                );
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Kelas', "next_url" => route('admin.synchronization-data-guru')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Kelas', 'error' => $e->getMessage()]);
        }
    }

    public function syncGuru()
    {
        try {
            DB::beginTransaction();

            $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'guru');
            $dataGuru = json_decode($responseKelas->body());

            foreach ($dataGuru as $item) {
                Guru::updateOrCreate(
                    ['id' => $item->id],
                    [
                        'nama' => $item->nama,
                        'email' => $item->email,
                        'no_hp' => $item->nomor_hp,
                        'password' => Hash::make($item->nip),
                        'photo_guru' => config('app.admin_url') . $item->foto_guru,
                        'created_at' => Carbon::parse($item->created_at),
                        'updated_at' => Carbon::parse($item->updated_at)
                    ]
                );
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Guru', "next_url" => route('admin.synchronization-data-siswa')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Guru', 'error' => $e->getMessage()]);
        }
    }

    public function syncSiswa(Request $response)
    {
        try {
            if (is_string($response->next_page)) {
                DB::beginTransaction();

                $url = ($response->next_page === 'undefined') ? config('app.admin_url_api') . 'siswa' : $response->next_page;

                $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get($url);
                $dataResponse = json_decode($responseKelas->body());
                $dataSiswa = $dataResponse->data;

                foreach ($dataSiswa as $item) {
                    User::updateOrCreate(
                        ['id' => $item->id],
                        [
                            'name' => $item->nama,
                            'email' => $item->email,
                            'no_hp' => $item->no_hp,
                            'password' => Hash::make($item->nis),
                            'nis' => $item->nis,
                            'kelas_id' => $item->kelas->id,
                            'jurusan_id' => $item->kelas->jurusan_id,
                            'absen' => $item->nomor_absen,
                            'jenis_kelamin' => strtoupper($item->gender),
                            'created_at' => Carbon::parse($item->created_at),
                            'updated_at' => Carbon::parse($item->updated_at)
                        ]
                    );
                }

                DB::commit();
                return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Siswa ' . (($dataResponse->last_page === $dataResponse->current_page) ? 'Terakhir' : 'Ke-' . $dataResponse->current_page), "next_url" => route('admin.synchronization-data-siswa'), 'next_page_url' => $dataResponse->next_page_url]);
            } else {
                return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Siswa', "next_url" => null]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Siswa', 'error' => $e->getMessage()]);
        }
    }
    public function authorizationQR()
    {
        $response = Http::withHeaders([
            'x-api-key' => config('app.api_key_bot_wa')
        ])->get(config('app.app_url_bot_wa') . '/start-session', [
                    'session' => 'PKL_SMKN1Mejayan',
                ]);

        $response = json_decode($response);

        return view('admin.authorizationQR', compact('response'));
    }

    public function setLibur()
    {
        return view('admin.set_libur');
    }

    public function setLiburSent()
    {
        try {
            DB::beginTransaction();

            $day = strtolower(Carbon::now()->dayName);

            $users = User::get(['id', $day]);

            foreach ($users as $item) {
                $datang = Carbon::createFromFormat('H:i', explode(" - ", $item->{$day})[0])->setDate(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day);
                $pulang = Carbon::createFromFormat('H:i', explode(" - ", $item->{$day})[1])->setDate(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day);

                $absensi = Absensi::where('user_id', $item->id)
                    ->whereDate('created_at', Carbon::today())
                    ->first();

                if ($absensi) {
                    $absensi->update([
                        'status' => 7,
                        'datang' => $datang,
                        'pulang' => $pulang,
                    ]);
                } else {
                    Absensi::create([
                        'user_id' => $item->id,
                        'status' => 7,
                        'datang' => $datang,
                        'pulang' => $pulang,
                        'created_at' => now()
                    ]);
                }
            }

            DB::commit();
            return to_route('admin.dashboard')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil menandai hari ini libur!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => $e->getMessage()
            ]);
        }
    }
}
