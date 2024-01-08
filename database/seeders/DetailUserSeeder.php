<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailUser::create(
            [
                'user_id' => User::latest()->first()->id,
                'nis' => '123456789',
                'jurusan_id' => 1,
                'kelas_id' => 2,
                'absen' => 25,
                'jenis_kelamin' => 'P',
                'alamat' => 'Kab Maidun, Kec Balerejo, Ds Sogo',
                'no_hp' => '081234567890',
                'no_hp_ortu' => '081234567891',
            ]
        );
    }
}
