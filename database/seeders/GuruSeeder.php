<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::create([
            'nama' => "Admin",
            'email' => config('app.admin_email'),
            'password' => Hash::make('admin-pkl-smkn-1-mejayan'),
            'status' => '1',
            'jurusan_id' => 1,
        ]);

        Guru::create([
            'nama' => "Pak Ananda",
            'email' => config('app.admin_email'),
            'password' => Hash::make('guru ini'),
            'status' => '1',
            'jurusan_id' => 1,
        ]);
    }
}
