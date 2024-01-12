<?php

namespace Database\Seeders;

use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\PengurusDudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengurusDudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengurusDudi::create([
            'guru_id' => Guru::latest()->first()->id,
            'dudi_id' => Dudi::latest()->first()->id,
        ]);
    }
}
