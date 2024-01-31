<?php

namespace App\Imports;

use App\Models\Dudi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DudiImport implements ToCollection, WithHeadingRow
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
                Dudi::create([
                    'id' => null,
                    'nama' => $row['nama'],
                    'pemimpin' => $row['pemimpin'],
                    'no_telp' => $row['no_telp'],
                    'email' => $row['email'],
                    'koordinat' => $row['koordinat'],
                    'radius' => $row['radius'],
                    'alamat' => $row['alamat'],
                    'jurusan_id' => auth()->guard('kakomli')->user()->jurusan_id,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
