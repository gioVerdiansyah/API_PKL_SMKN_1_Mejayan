<?php

namespace App\Imports\Admin;

use App\Models\Dudi;
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
                'id' => null,
                'nama' => $row['nama'],
                'pemimpin' => $row['pemimpin'],
                'no_telp' => $row['no_telp'],
                'email' => $row['email'],
                'koordinat' => $row['koordinat'],
                'radius' => $row['radius'],
                'alamat' => $row['alamat'],
                'jurusan_id' => $row['jurusan_id'],
                'senin' => $row['senin'],
                'selasa' => $row['selasa'],
                'rabu' => $row['rabu'],
                'kamis' => $row['kamis'],
                'jumat' => $row['jumat'],
                'sabtu' => $row['sabtu'],
                'minggu' => $row['minggu'],
                'ji_senin' => $row['ji_senin'],
                'ji_selasa' => $row['ji_selasa'],
                'ji_rabu' => $row['ji_rabu'],
                'ji_kamis' => $row['ji_kamis'],
                'ji_jumat' => $row['ji_jumat'],
                'ji_sabtu' => $row['ji_sabtu'],
                'ji_minggu' => $row['ji_minggu'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
