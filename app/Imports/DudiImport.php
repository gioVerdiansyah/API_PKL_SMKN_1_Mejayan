<?php

namespace App\Imports;

use App\Models\Dudi;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DudiImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
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
                'jurusan_id' =>  auth()->guard('kakomli')->user()->jurusan_id,
            ]);
        }
    }
}
