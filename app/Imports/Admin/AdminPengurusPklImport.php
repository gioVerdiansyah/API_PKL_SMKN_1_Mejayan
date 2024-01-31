<?php

namespace App\Imports\Admin;

use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class AdminPengurusPklImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $pengurus = new Guru;
            $pengurus->nama = $row['nama'];
            $pengurus->email = $row['email'];
            $pengurus->password = Hash::make($row['password'] ?? 'password');
            $pengurus->kakomli_id = $row['kakomli_id'];
            $pengurus->deskripsi = $row['deskripsi'];
            $pengurus->save();
        }
    }
}
