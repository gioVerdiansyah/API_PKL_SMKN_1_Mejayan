<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::insert([
            ['kelas' => "XII RPL 1"],
            ['kelas' => "XII RPL 2"],
            ['kelas' => "XII TKR 1"],
            ['kelas' => "XII TKR 2"],
            ['kelas' => "XII TBSM 1"],
            ['kelas' => "XII TBSM 2"],
            ['kelas' => "XII TBSM 3"],
            ['kelas' => "XII TO 1"],
            ['kelas' => "XII TO 2"],
            ['kelas' => "XII TO 3"],
            ['kelas' => "XII APHP 1"],
            ['kelas' => "XII APHP 2"],
            ['kelas' => "XII APHP 3"],
        ]);
    }
}
