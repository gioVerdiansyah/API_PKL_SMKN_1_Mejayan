<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\DetailUser;
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
        $detailUser->nik = $request->nik;
        $detailUser->jenis_kelamin = $request->jenis_kelamin;
        $detailUser->alamat = $request->alamat;
        $detailUser->no_hp = $request->no_hp;
        $detailUser->no_hp_ortu = $request->no_hp_ortu;
        $detailUser->tempat_dudi = $request->tempat_dudi;
        $detailUser->pemimpin_dudi = $request->pemimpin_dudi;
        $detailUser->no_telp_dudi = $request->no_telp_dudi;
        $detailUser->alamat_dudi = $request->alamat_dudi;
        $detailUser->koordinat = $request->koordinat;
        $user->detailUser()->save($detailUser);

        //return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'detail_user' => $detailUser
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}
