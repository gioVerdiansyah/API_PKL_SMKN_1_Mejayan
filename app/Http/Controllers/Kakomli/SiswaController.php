<?php

namespace App\Http\Controllers\Kakomli;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreAPIRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Imports\SiswaImport;
use App\Models\Absensi;
use App\Models\Jurnal;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = User::latest();
        $jurusans = Jurusan::all();

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $siswa->where('name', 'LIKE', '%' . $input . '%')
                ->orWhere('nis', 'LIKE', $input);
        }

        $siswa = $siswa->where('jurusan_id', auth()->guard('kakomli')->user()->jurusan_id)->paginate(10);

        return view('kakomli.siswa.index', compact('siswa', 'jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();
        return view('kakomli.siswa.create', compact('jurusan', 'kelas'));
    }

    public function createFromAPI()
    {
        try {
            $response = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'siswa');
            $data = json_decode($response->body());
            return view('kakomli.siswa.createFromAPI', compact('data'));
        } catch (\Exception) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => "Ada kesalahaan server!"
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $siswa = new User;
            $siswa->name = $request->nama;
            $siswa->nis = $request->nis;
            $siswa->email = $request->email;
            $siswa->password = Hash::make($request->password ?? 'password');
            $siswa->no_hp = $request->no_telp;
            $siswa->no_hp_ortu = $request->no_hp_ortu;
            $siswa->absen = $request->absen;
            $siswa->kelas_id = $request->kelas;
            $siswa->jurusan_id = $request->jurusan;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->alamat = $request->alamat;
            $siswa->senin = $request->senin;
            $siswa->selasa = $request->selasa;
            $siswa->rabu = $request->rabu;
            $siswa->kamis = $request->kamis;
            $siswa->jumat = $request->jumat;
            $siswa->sabtu = $request->sabtu;
            $siswa->minggu = $request->minggu;

            if($request->hasFile('photo_profile')){
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_siswa', $fileName);
                $siswa->photo_profile = 'storage/' . $path;
            }

            $siswa->save();

            DB::commit();
            return to_route('siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Berhasil menambah siswa ' . $request->nama
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => $e
            ]);
        }
    }

    public function storeFromAPI(UserStoreAPIRequest $request)
    {
        try {
            $siswa_id = $request->siswa_id;
            $response = Http::withHeader('x-api-key', config('app.api_key'))->post(config('app.admin_url_api') . 'selected-siswa', [
                'selectedSiswa' => $siswa_id
            ]);

            $data = json_decode($response->body());

            DB::beginTransaction();

            foreach ($data as $item) {
                $siswa = new User;
                $siswa->name = $item->nama;
                $siswa->email = $item->email;
                $siswa->password = Hash::make('password');
                $siswa->jenis_kelamin = strtoupper($item->gender);
                $siswa->no_hp = $item->no_hp;
                $siswa->jurusan_id = $item->kelas->jurusan_id;
                $siswa->kelas_id = $item->kelas_id;
                $siswa->nis = $item->nis;
                $siswa->absen = $item->nomor_absen;

                $siswa->senin = $request->senin;
                $siswa->selasa = $request->selasa;
                $siswa->rabu = $request->rabu;
                $siswa->kamis = $request->kamis;
                $siswa->jumat = $request->jumat;
                $siswa->sabtu = $request->sabtu;
                $siswa->minggu = $request->minggu;
                $siswa->save();
            }

            DB::commit();
            return to_route('siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => "Berhasil menambah siswa pkl"
            ]);
        } catch (\Exception) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => "Ada kesalahaan server!"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = User::where('id', $id)->first();
        if (!$siswa) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "ID siswa tidak ditemukan"
            ]);
        }

        return view('kakomli.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();
        $siswa = User::where('id', $id)->first();
        if (!$siswa) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'ID Siswa tidak ditemukan'
            ]);
        }

        return view('kakomli.siswa.edit', compact('siswa','jurusan', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $siswa = User::where('id', $id)->first();

            if (!$siswa) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Ada kesalahan server',
                    'text' => "ID siswa tidak ditemukan"
                ]);
            }

            $siswa->name = $request->nama;
            $siswa->nis = $request->nis;
            $siswa->email = $request->email;
            $siswa->password = Hash::make($request->password ?? 'password');
            $siswa->no_hp = $request->no_telp;
            $siswa->no_hp_ortu = $request->no_hp_ortu;
            $siswa->absen = $request->absen;
            $siswa->kelas_id = $request->kelas;
            $siswa->jurusan_id = $request->jurusan;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->alamat = $request->alamat;
            $siswa->senin = $request->senin;
            $siswa->selasa = $request->selasa;
            $siswa->rabu = $request->rabu;
            $siswa->kamis = $request->kamis;
            $siswa->jumat = $request->jumat;
            $siswa->sabtu = $request->sabtu;
            $siswa->minggu = $request->minggu;

            if ($request->password !== null) {
                $siswa->password = Hash::make($request->password);
            }

            if ($request->hasFile('photo_profile')) {
                if (strpos($siswa->photo_profile, 'storage/') !== false) {
                    if (Storage::exists(explode('storage/', $siswa->photo_profile)[1])) {
                        Storage::delete(explode('storage/', $siswa->photo_profile)[1]);
                    }
                }
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_siswa', $fileName);
                $siswa->photo_profile = 'storage/' . $path;
            }

            $siswa->save();

            DB::commit();
            return to_route('siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Berhasil me-update siswa'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $siswa = User::where('id', $id)->first();

            if (!$siswa) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'ID Siswa tidak ditemukan'
                ]);
            }
            $siswaName = $siswa->name;

            if (strpos($siswa->photo_profile, 'storage/') !== false) {
                if (Storage::exists(explode('storage/', $siswa->photo_profile)[1])) {
                    Storage::delete(explode('storage/', $siswa->photo_profile)[1]);
                }
            }

            $siswa->delete();

            DB::commit();
            return to_route('siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-hapus siswa $siswaName"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "Error: $e"
            ]);
        }
    }

    // Berurusan dengan Excel
    public function generateKolom()
    {
        return Excel::download(new SiswaExport(), 'tambah_data_siswa_pkl.xlsx');
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_excel' => [
                'required',
                'file',
                'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'mimes:xlsx',
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('message', [
                'icon' => 'error',
                'title' => 'Error validasi',
                'text' => 'harap masukkan file berupa .xlsx'
            ]);
        }
        try {
            $file = $request->file('file_excel');

            Excel::import(new SiswaImport, $file);

            return to_route('siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-import data"
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => $e
            ]);
        }
    }

    public function showPrintAbsensiSiswa(string $siswa_id)
    {
        $siswa = User::where('id', $siswa_id)->first();
        if (!$siswa) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Not Found',
                'text' => 'ID siswa tidak ditemukan'
            ]);
        }

        $absensi = Absensi::with('user')->where('user_id', $siswa->id)->get();

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

        return view('kakomli.rekap_pendataan.print-absensi-siswa', compact('siswa', 'dataBulan'));
    }
    public function printAbsensiSiswa(Request $request, string $siswa_id)
    {
        $kelompok = Kelompok::with([
            'anggota',
            'dudi' => function ($query) {
                $query->select(['id', 'nama', 'pemimpin']);
            }
        ])->whereHas('anggota', function ($query) use ($siswa_id) {
            $query->where('user_id', $siswa_id);
        })->first();

        $absensi = Absensi::with(['user.kelas'])
            ->where('user_id', $siswa_id)
            ->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])
            ->get();

        $bulanTahun = Carbon::createFromFormat('m-Y', $request->bulan)->locale('id');
        $absensiBulan = $bulanTahun->translatedFormat('F Y');

        $listUser = User::where('id', $siswa_id)->get();
        if ($request->tipe === "daftar-hadir") {
            return view('generate_pdf.rekap_daftar_absensi', compact('absensi', 'kelompok', 'absensiBulan', 'listUser'));
        }
        // dd($absensi->where('status', '1')->count());
        $bulannya = $request->bulan;
        return view('generate_pdf.rekap_absensi_kehadiran', compact('absensi', 'kelompok', 'absensiBulan', 'listUser', 'bulannya'));
    }
    public function showPrintJurnalSiswa(string $siswa_id)
    {
        $siswa = User::where('id', $siswa_id)->first();
        if (!$siswa) {
            return to_route('home')->with('message', [
                'icon' => 'error',
                'title' => 'Not Found',
                'text' => 'ID user / jurnal tidak ditemukan'
            ]);
        }

        $jurnal = Jurnal::with('user')->where('user_id', $siswa->id)->orderBy('created_at', 'desc')->get();

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
    public function printJurnalSiswa(Request $request, string $siswa_id)
    {
        $jurnal = Jurnal::with('user')->where('user_id', $siswa_id)->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$request->bulan])->get();
        $user = User::with(['kelas', 'jurusan'])->where('id', $siswa_id)->first();

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
        return view('generate_pdf.jurnal_siswa', ['dataJurnal' => $jurnal, 'user' => $user, 'kelompok' => $kelompok, 'isRekap' => true]);
    }
}
