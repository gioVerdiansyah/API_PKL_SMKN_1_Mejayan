<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $kelas = Kelas::where('kelas', $row['kelas_id'])->first();

            $user = new User;
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = Hash::make($row['password'] ?? 'password');
            $user->jurusan_id = Auth::guard('kakomli')->user()->jurusan_id;
            $user->kelas_id = $kelas->id ?? 1;
            $user->absen = $row['absen'];
            $user->nis = $row['nis'];
            $user->jenis_kelamin = $row['jenis_kelamin'];
            $user->alamat = $row['alamat'];
            $user->no_hp = $row['no_hp'];
            $user->no_hp_ortu = $row['no_hp_ortu'];
            $user->senin = $row['senin'];
            $user->selasa = $row['selasa'];
            $user->rabu = $row['rabu'];
            $user->kamis = $row['kamis'];
            $user->jumat = $row['jumat'];
            $user->sabtu = $row['sabtu'];
            $user->minggu = $row['minggu'];
            $user->save();
        }
    }
}
