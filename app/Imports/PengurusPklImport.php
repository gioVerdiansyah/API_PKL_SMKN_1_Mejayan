<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengurusPklImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $row) {
                $pengurus = new Guru;
                $pengurus->nama = $row['nama'];
                $pengurus->email = $row['email'];
                $pengurus->no_hp = $row['no_hp'];
                $pengurus->password = Hash::make($row['password'] ?? 'password');
                $pengurus->kakomli_id = auth()->guard('kakomli')->user()->id;
                $pengurus->deskripsi = $row['deskripsi'];
                $pengurus->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
