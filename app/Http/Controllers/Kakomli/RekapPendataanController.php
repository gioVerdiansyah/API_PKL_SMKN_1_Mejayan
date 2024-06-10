<?php

namespace App\Http\Controllers\Kakomli;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrintAbsensiPendataanRequest;
use App\Models\Absensi;
use App\Models\Dudi;
use App\Models\Jurnal;
use App\Models\Jurusan;
use App\Models\Kelompok;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapPendataanController extends Controller
{
    public function showDownloadPage()
    {
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first()->jurusan;
        return view('kakomli.rekap_pendataan.list-dudi', compact('jurusan'));
    }
    public function showDownloadPagePemetaan()
    {
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first()->jurusan;
        return view('kakomli.rekap_pendataan.pemetaan_dudi', compact('jurusan'));
    }

    public function downloadListDudi()
    {
        $dudi = Dudi::where('jurusan_id', auth()->guard('kakomli')->user()->jurusan_id)->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();
        $file_name = 'List_DuDi_Jurusan_' . $jurusan->jurusan;

        $pdf = PDF::setPaper('A4', 'portrait')->loadView('generate_pdf.list-dudi', ['dudi' => $dudi, 'jurusan' => $jurusan]);

        return $pdf->download($file_name . '.pdf');
    }

    public function printListDudi()
    {
        $dudi = Dudi::where('jurusan_id', auth()->guard('kakomli')->user()->jurusan_id)->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();

        return view('print_pdf.list-dudi', compact('dudi', 'jurusan'));
    }
    public function downloadPemetaanDudi()
    {
        $kelompok = Kelompok::with(['dudi', 'guru', 'anggota', 'anggota.user.kelas',])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->orderBy('created_at', 'asc')->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();
        $file_name = 'Pemetaan_DuDi_Jurusan_' . $jurusan->jurusan;

        $pdf = PDF::setPaper('A4', 'portrait')->loadView('generate_pdf.pemetaan_dudi', ['kelompok' => $kelompok, 'jurusan' => $jurusan]);

        return $pdf->download($file_name . '.pdf');
    }

    public function printPemetaanDudi()
    {
        $kelompok = Kelompok::with(['dudi', 'guru', 'anggota', 'anggota.users.kelas',])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->orderBy('created_at', 'asc')->get();
        $jurusan = Jurusan::where('id', auth()->guard('kakomli')->user()->jurusan_id)->first();

        return view('print_pdf.pemetaan_dudi', compact('kelompok', 'jurusan'));
    }

    public function showPrintAbsensiSiswa()
    {
        $kelompok = Kelompok::with([
            'dudi' => function ($query) {
                $query->select(['id', 'nama']);
            }
        ])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->get();

        $absen = Kelompok::with([
            'anggota',
            'dudi' => function ($query) {
                $query->select(['id', 'nama']);
            }
        ])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->first();

        if (!$absen) {
            $absen = (object) [
                'anggota' => collect([['user_id' => null]]),
                'dudi' => []
            ];
        }

        $absensi = Absensi::with('user')->whereIn('user_id', $absen->anggota->pluck('user_id'))->orderBy('created_at', 'desc')->get();

        $uniqueMonths = $absensi->pluck('created_at')->map(function ($createdAt) {
            $date = Carbon::parse($createdAt);
            $year = $date->format('Y');
            $month = $date->format('m') . '-' . $year;
            $namaBulan = $date->translatedFormat('F');
            if ($year < date('Y')) {
                $namaBulan .= ' ' . $year;
            }
            return [
                'bulan' => $month,
                'nama_bulan' => $namaBulan
            ];
        })->unique();

        $dataBulan = $uniqueMonths->values()->all();

        return view('kakomli.rekap_pendataan.print-absensi-siswa', compact('kelompok', 'dataBulan'));
    }
    public function printAbsensiSiswa(PrintAbsensiPendataanRequest $request)
    {
        $kelompok = Kelompok::with([
            'anggota',
            'dudi' => function ($query) {
                $query->select(['id', 'nama', 'pemimpin']);
            }
        ])->where('kakomli_id', auth()->guard('kakomli')->user()->id)->where('nama_kelompok', $request->nama_kelompok)->first();

        if (!$kelompok) {
            $kelompok = (object) [
                'anggota' => collect([['user_id' => null]]),
                'dudi' => []
            ];
        }

        $absensi = Absensi::with(['user.kelas'])
            ->whereIn('user_id', $kelompok->anggota->pluck('user_id'))
            ->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])
            ->orderBy('created_at', 'asc')
            ->get();

        $bulanTahun = Carbon::createFromFormat('m-Y', $request->bulan)->locale('id');
        $absensiBulan = $bulanTahun->translatedFormat('F Y');

        $listUser = User::whereIn('id', $kelompok->anggota->pluck('user_id'))->get();
        if ($request->tipe === "daftar-hadir") {
            return view('generate_pdf.rekap_daftar_absensi', compact('absensi', 'kelompok', 'absensiBulan', 'listUser'));
        }
        // dd($absensi->where('status', '1')->count());
        $bulannya = $request->bulan;
        return view('generate_pdf.rekap_absensi_kehadiran', compact('absensi', 'kelompok', 'absensiBulan', 'listUser', 'bulannya'));
    }
    public function showPrintJurnalSiswa()
    {
        $kelompok = Kelompok::with(['anggota'])->whereHas('kakomli', function($query){
            $query->where('id', auth()->guard('kakomli')->user()->id);
        })->get();

        $listUserId = array_merge(...$kelompok->pluck('anggota.*.user_id')->toArray());

        $siswa = User::whereIn('id', $listUserId)->get();

        $jurnal = Jurnal::with('user')->whereIn('user_id', $siswa->pluck('id'))->orderBy('created_at', 'desc')->get();

        $uniqueMonths = $jurnal->pluck('created_at')->map(function ($createdAt) {
            $date = Carbon::parse($createdAt);
            $year = $date->format('Y');
            $month = $date->format('m') . '-' . $year;
            $namaBulan = $date->translatedFormat('F');
            if ($year < date('Y')) {
                $namaBulan .= ' ' . $year;
            }
            return [
                'bulan' => $month,
                'nama_bulan' => $namaBulan
            ];
        })->unique();

        $dataBulan = $uniqueMonths->values()->all();

        return view('kakomli.rekap_pendataan.print-jurnal-siswa', compact('siswa', 'dataBulan'));
    }
    public function printJurnalSiswa(Request $request)
    {
        $jurnal = Jurnal::with('user')->where('status', '1')->where('user_id', $request->siswa)->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])->orderBy('created_at', 'asc')->get();
        $user = User::with(['kelas', 'jurusan'])->where('id', $request->siswa)->first();

        $kelompok = Kelompok::with(['dudi', 'guru'])->whereHas('anggota', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();

        if (!$jurnal || !$user) {
            return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => 'ID user / jurnal tidak ditemukan']);
        }
        return view('generate_pdf.jurnal_siswa', ['dataJurnal' => $jurnal, 'user' => $user, 'kelompok' => $kelompok, 'isRekap' => true]);
    }
}
