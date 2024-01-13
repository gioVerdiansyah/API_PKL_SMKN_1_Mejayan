<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
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
            $jurusan = Jurusan::where('jurusan', $row['jurusan_id'])->first();
            $kelas = Kelas::where('kelas', $row['kelas_id'])->first();

            $user = new User;
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = $row['password'] ?? 'password';
            $user->jurusan_id = $jurusan->id ?? 1;
            $user->kelas_id = $kelas->id ?? 1;
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
