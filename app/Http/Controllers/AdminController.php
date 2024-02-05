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
                $existingJurusan = Jurusan::find($item->id);

                if ($existingJurusan && $existingJurusan->updated_at != $item->updated_at) {
                    $existingJurusan->jurusan = $item->jurusan;
                    $existingJurusan->full_name = $item->full_name;
                    $existingJurusan->gambar = config('app.admin_url') . $item->gambar;
                    $existingJurusan->created_at = $item->created_at;
                    $existingJurusan->updated_at = $item->updated_at;
                    $existingJurusan->save();

                } elseif (!$existingJurusan) {
                    $newJurusan = new Jurusan();
                    $newJurusan->id = $item->id;
                    $newJurusan->jurusan = $item->jurusan;
                    $newJurusan->full_name = $item->full_name;
                    $newJurusan->gambar = config('app.admin_url') . $item->gambar;
                    $newJurusan->created_at = $item->created_at;
                    $newJurusan->updated_at = $item->updated_at;
                    $newJurusan->save();
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Jurusan', 'next_url' => route('admin.synchronization-data-kelas')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "DONE", 'type' => 'Jurusan','error' => $e->getMessage()]);
        }
    }

    public function syncKelas(){
        try{
            DB::beginTransaction();

            $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'kelas');
            $dataKelas = json_decode($responseKelas->body());

            foreach ($dataKelas as $item) {
                $existingKelas = Kelas::find($item->id);

                if ($existingKelas && $existingKelas->updated_at != $item->updated_at) {
                    $existingKelas->kelas = $item->tingkatan . ' ' . $item->kelas;
                    $existingKelas->created_at = Carbon::parse($item->created_at);
                    $existingKelas->updated_at = Carbon::parse($item->updated_at);
                    $existingKelas->save();
                } elseif (!$existingKelas) {
                    $newKelas = new Kelas();
                    $newKelas->id = $item->id;
                    $newKelas->kelas = $item->tingkatan . ' ' . $item->kelas;
                    $newKelas->created_at = Carbon::parse($item->created_at);
                    $newKelas->updated_at = Carbon::parse($item->updated_at);
                    $newKelas->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Kelas', "next_url" => route('admin.synchronization-data-guru')]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Kelas', 'error' => $e->getMessage()]);
        }
    }

    public function syncGuru(){
        try {
            DB::beginTransaction();

            $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'guru');
            $dataGuru = json_decode($responseKelas->body());

            foreach ($dataGuru as $item) {
                $existingGuru = Guru::find($item->id);

                if ($existingGuru && $existingGuru->updated_at != $item->updated_at) {
                    $existingGuru->nama = $item->nama;
                    $existingGuru->email = $item->email;
                    $existingGuru->no_hp = $item->nomor_hp;
                    $existingGuru->email = $item->email;
                    $existingGuru->password = Hash::make($item->nip);
                    $existingGuru->photo_guru = config('app.admin_url') . $item->foto_guru;
                    $existingGuru->created_at = Carbon::parse($item->created_at);
                    $existingGuru->updated_at = Carbon::parse($item->updated_at);
                    $existingGuru->save();
                } elseif (!$existingGuru) {
                    $newGuru = new Guru();
                    $newGuru->id = $item->id;
                    $newGuru->nama = $item->nama;
                    $newGuru->email = $item->email;
                    $newGuru->email = $item->email;
                    $newGuru->no_hp = $item->nomor_hp;
                    $newGuru->email = $item->email;
                    $newGuru->password = Hash::make($item->nip);
                    $newGuru->photo_guru = config('app.admin_url') . $item->foto_guru;
                    $newGuru->created_at = Carbon::parse($item->created_at);
                    $newGuru->updated_at = Carbon::parse($item->updated_at);
                    $newGuru->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Guru' , "next_url" => route('admin.synchronization-data-siswa')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Guru' , 'error' => $e->getMessage()]);
        }
    }

    public function syncSiswa(Request $response){
        try {
            if(is_string($response->next_page)){
            DB::beginTransaction();

            $url = ($response->next_page === 'undefined') ? config('app.admin_url_api') . 'siswa' : $response->next_page;

            $responseKelas = Http::withHeader('x-api-key', config('app.api_key'))->get($url);
            $dataResponse = json_decode($responseKelas->body());
            $dataSiswa = $dataResponse->data;

            foreach ($dataSiswa as $item) {
                $existingSiswa = User::find($item->id);

                if ($existingSiswa && $existingSiswa->updated_at != $item->updated_at) {
                    $existingSiswa->name = $item->nama;
                    $existingSiswa->email = $item->email;
                    $existingSiswa->no_hp = $item->no_hp;
                    $existingSiswa->email = $item->email;
                    $existingSiswa->password = Hash::make($item->nis);
                    $existingSiswa->nis = $item->nis;
                    $existingSiswa->kelas_id = $item->kelas->id;
                    $existingSiswa->jurusan_id = $item->kelas->jurusan_id;
                    $existingSiswa->absen = $item->nomor_absen;
                    $existingSiswa->jenis_kelamin = strtoupper($item->gender);
                    $existingSiswa->created_at = Carbon::parse($item->created_at);
                    $existingSiswa->updated_at = Carbon::parse($item->updated_at);
                    $existingSiswa->save();
                } elseif (!$existingSiswa) {
                    $newSiswa = new User();
                    $newSiswa->id = $item->id;
                    $newSiswa->name = $item->nama;
                    $newSiswa->email = $item->email;
                    $newSiswa->no_hp = $item->no_hp;
                    $newSiswa->email = $item->email;
                    $newSiswa->password = Hash::make($item->nis);
                    $newSiswa->nis = $item->nis;
                    $newSiswa->kelas_id = $item->kelas->id;
                    $newSiswa->jurusan_id = $item->kelas->jurusan_id;
                    $newSiswa->absen = $item->nomor_absen;
                    $newSiswa->jenis_kelamin = strtoupper($item->gender);
                    $newSiswa->created_at = Carbon::parse($item->created_at);
                    $newSiswa->updated_at = Carbon::parse($item->updated_at);
                    $newSiswa->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Siswa ' . (($dataResponse->last_page === $dataResponse->current_page) ? 'Terakhir' : 'Ke-' . $dataResponse->current_page), "next_url" => route('admin.synchronization-data-siswa'), 'next_page_url' => $dataResponse->next_page_url]);
        }else{
            return response()->json(['success' => true, 'message' => "DONE", 'type' => 'Siswa', "next_url" => null]);
        }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "FAIL", 'type' => 'Siswa',  'error' => $e->getMessage()]);
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
}
