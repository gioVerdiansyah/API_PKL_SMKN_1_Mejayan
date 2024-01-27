<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kakomli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KakomliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kakomli::create([
            'nama' => "Admin Ini",
            'email' => 'admin@smkn1mejayan.sch.id',
            'password' => Hash::make('admin-pkl-smkn-1-mejayan'),
            'photo_profile' => 'images/app/LOGO_SMK.png',
            'jurusan_id' => 1,
        ]);
    }
}
