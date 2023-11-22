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
                'nik' => '123456789',
                'jurusan'=> 'RPL',
                'kelas' => 'XI',
                'jenis_kelamin' => 'P',
                'alamat' => 'Kab Maidun, Kec Balerejo, Ds Sogo',
                'no_hp' => '081234567890',
                'no_hp_ortu' => '081234567891',
            ]
        );
    }
}
