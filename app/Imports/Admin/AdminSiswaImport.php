<?php

namespace App\Imports\Admin;

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
            $user->password = Hash::make($row['password'] ?? 'password');
            $user->jurusan_id = $row['jurusan_id'];
            $user->kelas_id = $row['kelas_id'];
            $user->absen = $row['absen'];
            $user->nis = $row['nis'];
            $user->jenis_kelamin = $row['jenis_kelamin'];
            $user->alamat = $row['alamat'];
            $user->no_hp = $row['no_hp'];
            $user->no_hp_ortu = $row['no_hp_ortu'];
            $user->save();
        }
    }
}
