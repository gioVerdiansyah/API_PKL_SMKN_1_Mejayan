<?php

namespace Database\Seeders;

use App\Models\DetailPkl;
use App\Models\DetailUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPklSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailPkl::create([
            'detail_user_id' => DetailUser::first()->id,
            'tempat_dudi' => 'HummaTech',
            'pemimpin_dudi' => 'Afrizal',
            'no_telp_dudi' => '082132560566',
            'alamat_dudi' => 'Perum Permata Regency 1 Blok 10/28, Perun Gpa, Ngijo, Kec. Karang Ploso, Kabupaten Malang, Jawa Timur 65152',
            'koordinat' => '-7.900044393286019, 112.6069118963316',
        ]);
    }
}
