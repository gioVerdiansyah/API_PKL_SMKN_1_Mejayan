<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function showPrintJurnalSiswa(string $id)
    {
        return view('print_jurnal', compact('id'));
    }
    public function printJurnalSiswa(Request $request)
    {
        try {
            $jurnal = Jurnal::with('user')->where('user_id', $request->user_id)->get();
            $user = User::with(['detailUser', 'detailUser.jurusan'])->where('id', $request->user_id)->first();

            if (!$jurnal || !$user) {
                return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => 'ID user /jurnal tidak ditemukan']);
            }

            sleep(10);

            $base_path = 'app/public/jurnal_siswa';
            $file_name = str_replace(' ', '_', $user->name);
            $path = storage_path($base_path .'/'. $file_name . '.pdf');

            if(file_exists($path)){
                unlink($path);
            }
            $pdf = PDF::setPaper('A4', 'potrait')->loadView('generate_pdf.jurnal_siswa', ['dataJurnal' => $jurnal, 'user' => $user]);
            $folder_exist = storage_path($base_path);
            if (!file_exists($folder_exist)) {
                mkdir($folder_exist, 0755, true);
            }
            $pdf->save($path);

            return response()->json(['success' => true, 'message' => 'Data berhasil di temukan!!!', 'pdf_url' => url("storage/jurnal_siswa/$file_name" . '.pdf'), 'name_file' => 'Jurnal_PKL_' . $file_name]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ada kesalahan server', 'error' => $e]);
        }
    }
}
