<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use App\Models\Jurusan;
use App\Models\Kelompok;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminRekapPendataanController extends Controller
{
    public function showDownloadPage(){
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first()->jurusan;
        return view('admin.kakomli.rekap_pendataan.list-dudi', compact('jurusan'));
    }
    public function showDownloadPagePemetaan(){
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first()->jurusan;
        return view('admin.kakomli.rekap_pendataan.pemetaan_dudi', compact('jurusan'));
    }

    public function downloadListDudi(){
        $dudi = Dudi::where('jurusan_id', auth()->guard('kakomli')->user()->jurusan_id)->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();
        $file_name = 'List_DuDi_Jurusan_' . $jurusan->jurusan;

        $pdf = PDF::setPaper('A4', 'portrait')->loadView('generate_pdf.list-dudi', ['dudi' => $dudi, 'jurusan' => $jurusan]);

        return $pdf->download($file_name . '.pdf');
    }

    public function printListDudi(){
        $dudi = Dudi::where('jurusan_id', auth()->guard('kakomli')->user()->jurusan_id)->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();

        return view('print_pdf.list-dudi', compact('dudi', 'jurusan'));
    }
    public function downloadPemetaanDudi(){
        $kelompok = Kelompok::with(['dudi', 'guru', 'anggota', 'anggota.user.kelas',])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->orderBy('created_at', 'asc')->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();
        $file_name = 'Pemetaan_DuDi_Jurusan_' . $jurusan->jurusan;

        $pdf = PDF::setPaper('A4', 'portrait')->loadView('generate_pdf.pemetaan_dudi', ['kelompok' => $kelompok, 'jurusan' => $jurusan]);

        return $pdf->download($file_name . '.pdf');
    }

    public function printPemetaanDudi(){
        $kelompok = Kelompok::with(['dudi', 'guru', 'anggota', 'anggota.users.kelas',])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->orderBy('created_at', 'asc')->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();

        return view('print_pdf.pemetaan_dudi', compact('kelompok', 'jurusan'));
    }
}
