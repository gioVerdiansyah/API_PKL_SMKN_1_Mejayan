<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::insert([
            ['jurusan' => "RPL", 'full_name' => "Rekayasa Perangkat Lunak", 'gambar' => asset('images/jurusan/RPL.png')],
            ['jurusan' => "TKR", 'full_name' => "Teknik Kendaraan Ringan", 'gambar' => asset('images/jurusan/TKR.png')],
            ['jurusan' => "TBSM", 'full_name' => "Teknik Bisnis Sepeda Motor", 'gambar' => asset('images/jurusan/TBSM.png')],
            ['jurusan' => "TO", 'full_name' => "Teknik Ototronik", 'gambar' => asset('images/jurusan/TO.png')],
            ['jurusan' => "APHP", 'full_name' => "Agribisnis Pengolahan Hasil Pertanian", 'gambar' => asset('images/jurusan/APHP.png')],
        ]);
    }
}
