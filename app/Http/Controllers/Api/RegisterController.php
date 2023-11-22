<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\DetailPkl;
use App\Models\DetailUser;
use App\Models\JamPkl;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserStoreRequest $request)
    {

        //create user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->nik);
        $user->save();

        // create detail user
        $detailUser = new DetailUser();
        $detailUser->user_id = $user->id;
        $detailUser->jurusan = $request->jurusan;
        $detailUser->kelas = $request->kelas;
        $detailUser->nis = $request->nis;
        $detailUser->jenis_kelamin = $request->jenis_kelamin;
        $detailUser->alamat = $request->alamat;
        $detailUser->no_hp = $request->no_hp;
        $detailUser->no_hp_ortu = $request->no_hp_ortu;
        $user->detailUser()->save($detailUser);

        $detailPkl = new DetailPkl;
        $detailPkl->detail_user_id = $detailUser->id;
        $detailPkl->tempat_dudi = $request->tempat_dudi;
        $detailPkl->pemimpin_dudi = $request->pemimpin_dudi;
        $detailPkl->no_telp_dudi = $request->no_telp_dudi;
        $detailPkl->alamat_dudi = $request->alamat_dudi;
        $detailPkl->koordinat = $request->koordinat;
        $detailUser->detailPkl()->save($detailPkl);


        $jamPkl = new JamPkl;
        $jamPkl->detail_pkl_id = $detailPkl->id;
        $jamPkl->senin = $request->senin_awal . ' - ' . $request->senin_akhir;
        $jamPkl->selasa = $request->selasa_awal . ' - ' . $request->selasa_akhir;
        $jamPkl->rabu = $request->rabu_awal . ' - ' . $request->rabu_akhir;
        $jamPkl->kamis = $request->kamis_awal . ' - ' . $request->kamis_akhir;
        $jamPkl->jumat = $request->jumat_awal . ' - ' . $request->jumat_akhir;
        $jamPkl->saptu = $request->saptu_awal && $request->saptu_akhir ? $request->saptu_awal . ' - ' . $request->saptu_akhir : null;
        $jamPkl->minggu = $request->minggu_awal && $request->minggu_akhir ? $request->minggu_awal . ' - ' . $request->minggu_akhir : null;

        $jamPkl->ji_senin = $request->ji_senin_awal . ' - ' . $request->ji_senin_akhir;
        $jamPkl->ji_selasa = $request->ji_selasa_awal . ' - ' . $request->ji_selasa_akhir;
        $jamPkl->ji_rabu = $request->ji_rabu_awal . ' - ' . $request->ji_rabu_akhir;
        $jamPkl->ji_kamis = $request->ji_kamis_awal . ' - ' . $request->ji_kamis_akhir;
        $jamPkl->ji_jumat = $request->ji_jumat_awal . ' - ' . $request->ji_jumat_akhir;
        $jamPkl->ji_saptu = $request->ji_saptu_awal && $request->ji_saptu_akhir ? $request->ji_saptu_awal . ' - ' . $request->ji_saptu_akhir : null;
        $jamPkl->ji_minggu = $request->ji_minggu_awal && $request->ji_minggu_akhir ? $request->ji_minggu_awal . ' - ' . $request->ji_minggu_akhir : null;

        $detailPkl->jamPkl()->save($jamPkl);

        //return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}
