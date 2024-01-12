<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'id' => Str::uuid(),
                'guru_id' => Guru::where('email', config('app.admin_email'))->first()->id,
                'name' => 'Verdi',
                'email' => 'e01010010or@gmail.com',
                'password' => Hash::make('user baru'),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
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
