<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class PengurusPklImport implements ToCollection, WithHeadingRow
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
            $pengurus->gelar = $row['gelar'];
            $pengurus->email = $row['email'];
            $pengurus->password = Hash::make($row['password'] ?? 'password');
            $pengurus->kakomli_id = auth()->guard('kakomli')->user()->id;
            $pengurus->deskripsi = $row['deskripsi'];
            $pengurus->save();
        }
    }
}
