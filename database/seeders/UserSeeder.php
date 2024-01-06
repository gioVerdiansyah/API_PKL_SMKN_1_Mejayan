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
                'guru_id' => Guru::latest()->first()->id,
                'name' => 'Verdi',
                'email' => 'e01010010or@gmail.com',
                'password' => Hash::make('user baru'),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
