<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function getColumn(){
        $model = new Dudi();
        $columns = $model->getTableColumns();
        dump($columns);
    }

    public function tableDudiList(){
        $dudi = Dudi::where('jurusan_id', auth()->guard('kakomli')->user()->jurusan_id)->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();
        return view('generate_pdf.list-dudi', compact('dudi', 'jurusan'));
    }

    public function tablePemetaanDudi(){
        $kelompok = Kelompok::with(['dudi', 'guru', 'anggota', 'anggota.user.kelas',])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->orderBy('created_at', 'asc')->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first()->jurusan;

        return view('generate_pdf.pemetaan_dudi', compact('kelompok', 'jurusan'));
    }

    public function showEmailTest(){
        return view('emails.contact_me');
    }
}
