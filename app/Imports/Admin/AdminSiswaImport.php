<?php

namespace App\Imports\Admin;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminSiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = new User;
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = Hash::make($row['nis']);
            $user->jurusan_id = Jurusan::where('jurusan', $row['jurusan_id'])->first()->id;
            $user->kelas_id = Kelas::where('kelas', $row['kelas_id'])->first()->id;
            $user->absen = $row['absen'];
            $user->nis = $row['nis'];
            $user->jenis_kelamin = strtoupper($row['jenis_kelamin']);
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
