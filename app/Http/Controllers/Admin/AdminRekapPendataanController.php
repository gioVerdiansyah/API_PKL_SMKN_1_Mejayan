<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Dudi;
use App\Models\Jurnal;
use App\Models\Jurusan;
use App\Models\Kakomli;
use App\Models\Kelompok;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminRekapPendataanController extends Controller
{
    public function showDownloadPage(){
        $jurusan = Jurusan::all();
        return view('admin.kakomli.rekap_pendataan.list-dudi', compact('jurusan'));
    }
    public function showDownloadPagePemetaan(){
        $jurusan = Jurusan::all();
        return view('admin.kakomli.rekap_pendataan.pemetaan_dudi', compact('jurusan'));
    }
    public function printListDudi(Request $request){
        $dudi = Dudi::where('jurusan_id', $request->jurusan)->get();
        $jurusan = Jurusan::where('id', $request->jurusan)->first();

        return view('print_pdf.list-dudi', compact('dudi', 'jurusan'));
    }
    public function printPemetaanDudi(Request $request){
        $kakomli = Kakomli::select('jurusan_id', 'id')->where('jurusan_id', $request->jurusan)->whereNot('email', config('app.admin_email'))->first();
        $jurusan = Jurusan::where('id', $request->jurusan)->first();
        $kelompok = Kelompok::with(['dudi', 'guru', 'anggota', 'anggota.users.kelas',])->where('kakomli_id', $kakomli->id)->orderBy('created_at', 'asc')->get();

        return view('print_pdf.pemetaan_dudi', compact('kelompok', 'jurusan'));
    }



    public function showPrintAbsensiSiswa()
    {
        $kelompok = Kelompok::with([
            'dudi' => function ($query) {
                $query->select(['id', 'nama']);
            }
        ])->get();

        $absen = Kelompok::with([
            'anggota',
            'dudi' => function ($query) {
                $query->select(['id', 'nama']);
            }
        ])->first();

        if (!$absen) {
            $absen = (object) [
                'anggota' => collect([['user_id' => null]]),
                'dudi' => []
            ];
        }

        $absensi = Absensi::with('user')->whereIn('user_id', $absen->anggota->pluck('user_id'))->get();

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

        return view('admin.kakomli.rekap_pendataan.print-absensi-siswa', compact('kelompok', 'dataBulan'));
    }
    public function printAbsensiSiswa(Request $request)
    {
        $kelompok = Kelompok::with([
            'anggota',
            'dudi' => function ($query) {
                $query->select(['id', 'nama', 'pemimpin']);
            }
        ])->where('nama_kelompok', $request->nama_kelompok)->first();

        if (!$kelompok) {
            $kelompok = (object) [
                'anggota' => collect([['user_id' => null]]),
                'dudi' => []
            ];
        }

        $absensi = Absensi::with(['user.kelas'])
            ->whereIn('user_id', $kelompok->anggota->pluck('user_id'))
            ->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])
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
        $kelompok = Kelompok::with(['anggota'])->get();

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

        return view('admin.kakomli.rekap_pendataan.print-jurnal-siswa', compact('siswa', 'dataBulan'));
    }
    public function printJurnalSiswa(Request $request)
    {
        $jurnal = Jurnal::with('user')->where('user_id', $request->siswa)->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])->get();
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
