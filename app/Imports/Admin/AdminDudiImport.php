<?php

namespace App\Imports\Admin;

use App\Models\Dudi;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AdminDudiImport implements ToCollection, WithHeadingRow
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
                'nama' => $row['nama'],
                'pemimpin' => $row['pemimpin'],
                'no_telp' => $row['no_telp'],
                'email' => $row['email'],
                'koordinat' => $row['koordinat'],
                'radius' => $row['radius'],
                'alamat' => $row['alamat'],
                'jurusan_id' => Jurusan::where('jurusan', $row['jurusan_id'])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
