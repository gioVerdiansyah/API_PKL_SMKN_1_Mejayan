<?php

namespace App\Http\Controllers;

use App\Mail\AgreementMail;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function persetujuan()
    {
        $guru = Guru::with('jurusan')->where('status', '0')->get();
        return view('admin.persetujuan', compact('guru'));
    }

    public function acceptOrReject(Request $request, string $id)
    {
        try {
            $status = $request->status == 1 ? 'agree' : 'disagree';
            DB::beginTransaction();

            $guru = Guru::with('jurusan')->where('id', $id)->first();
            if (!$guru) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => "Error!",
                    'text' => "ID Guru tidak ditemukan!"
                ]);
            }

            $guru->status = $request->status;
            $guru->save();


            Mail::to($guru->email)->send(new AgreementMail($guru, $status));

            // if($request->status == 0){
            //     $guru->delete();
            // }

            DB::commit();
            return to_route('admin.persetujuan')->with('message', [
                'icon' => 'success',
                'title' => 'Berhasil!',
                'text' => "Berhasil " . ($request->status == 1 ? 'menyetujui' : 'menolak') . " guru {$guru->nama} menjadi ketua jurusan {$guru->jurusan->jurusan}"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => "Error!",
                'text' => "Error: $e"
            ]);
        }
    }
}
