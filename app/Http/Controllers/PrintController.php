<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuruPrintAbsensiSiswaRequest;
use App\Http\Requests\SiswaPrintJurnalRequest;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Jurnal;
use App\Models\Kelompok;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function showPrintJurnalSiswa(string $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return to_route('home')->with('message', [
                'icon' => 'error',
                'title' => 'Not Found',
                'text' => 'ID user / jurnal tidak ditemukan'
            ]);
        }

        $jurnal = Jurnal::with('user')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

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

        return view('print_jurnal', compact('id', 'dataBulan'));
    }
    public function printJurnalSiswa(SiswaPrintJurnalRequest $request)
    {
        try {
            $jurnal = Jurnal::with('user')->where('user_id', $request->user_id)->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])->orderBy('created_at', 'asc')->get();
            $user = User::with(['kelas', 'jurusan'])->where('id', $request->user_id)->first();

            $kelompok = Kelompok::with(['dudi', 'guru'])->whereHas('anggota', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();

            if (!$jurnal || !$user) {
                return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => 'ID user / jurnal tidak ditemukan']);
            }

            $base_path = 'app/public/jurnal_siswa';
            $file_name = 'Jurnal_PKL_' . str_replace(' ', '_', $user->name) . "_" . $request->bulan;
            $path = storage_path($base_path . '/' . $file_name . '.pdf');

            if (file_exists($path)) {
                unlink($path);
            }
            $pdf = PDF::setPaper('A4', 'potrait')->loadView('generate_pdf.jurnal_siswa', ['dataJurnal' => $jurnal, 'user' => $user, 'kelompok' => $kelompok, 'isRekap' => false]);
            $folder_exist = storage_path($base_path);
            if (!file_exists($folder_exist)) {
                mkdir($folder_exist, 0755, true);
            }
            $pdf->save($path);

            return response()->json(['success' => true, 'message' => 'PDF Jurnal berhasil di generate!', 'pdf_url' => url("storage/jurnal_siswa/$file_name" . '.pdf'), 'name_file' => $file_name]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => $e, 'bulan' => $request->bulan]);
        }
    }

    public function showPrintAbensiSiswa(string $guru_id)
    {
        try {
            $guru = Guru::where('id', $guru_id)->first();

            if (!$guru) {
                return to_route('home')->with('message', [
                    'icon' => 'error',
                    'title' => 'Not Found',
                    'text' => 'ID guru tidak ditemukan'
                ]);
            }

            $guru_id = $guru->id;
            $kelompok = Kelompok::with([
                'dudi' => function ($query) {
                    $query->select(['id', 'nama']);
                }
            ])->where('guru_id', $guru_id)->get();

            $absen = Kelompok::with([
                'anggota',
                'dudi' => function ($query) {
                    $query->select(['id', 'nama']);
                }
            ])->where('guru_id', $guru_id)->first();

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

            return view('print_absensi', compact('guru', 'kelompok', 'dataBulan'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"], 500);
        }
    }

    public function printAbsensiSiswa(GuruPrintAbsensiSiswaRequest $request, string $guru_id)
    {
        try {
            $nama_kelompok = $request->kelompok;
            $listKelompok = Kelompok::where('guru_id', $guru_id)->pluck('nama_kelompok')->toArray();

            $namaKelompok = $nama_kelompok ?? ($listKelompok[0] ?? '!kelompok');

            $kelompok = Kelompok::with([
                'anggota',
                'dudi' => function ($query) {
                    $query->select(['id', 'nama', 'pemimpin']);
                }
            ])->where('guru_id', $guru_id)->where('nama_kelompok', $namaKelompok)->first();

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
            $bulannya = $request->bulan;
            return view('generate_pdf.rekap_absensi_kehadiran', compact('absensi', 'kelompok', 'absensiBulan', 'listUser', 'bulannya'));

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: {$e->getMessage()}"], 500);
        }
    }
    public function absenPrint(string $guru_id)
    {
        try {
            $guru = Guru::with('jurusan')->where('id', $guru_id)->first();

            if (!$guru) {
                return response()->json(['success' => false, 'message' => 'ID guru tidak ditemukan']);
            }

            $dataAbsensi = Absensi::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                },
                'user.detailUser.detailPkl.jamPkl'
            ])->get();

            if (!$dataAbsensi) {
                return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => 'ID absensi tidak ditemukan']);
            }

            return view('generate_pdf.rekap_absensi', compact('dataAbsensi', 'guru'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => $e]);
        }
    }
}
