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
            ['jurusan' => "RPL", 'gambar' => asset('images/jurusan/RPL.png')],
            ['jurusan' => "TKR", 'gambar' => asset('images/jurusan/TKR.png')],
            ['jurusan' => "TBSM", 'gambar' => asset('images/jurusan/TBSM.png')],
            ['jurusan' => "TO", 'gambar' => asset('images/jurusan/TO.png')],
            ['jurusan' => "APHP", 'gambar' => asset('images/jurusan/APHP.png')],
        ]);
    }
}
