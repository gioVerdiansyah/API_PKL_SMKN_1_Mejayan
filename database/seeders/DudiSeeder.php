<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use App\Models\Dudi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dudi::create([
            'nama' => 'HummaTech',
            'pemimpin' => 'Afrizal',
            'no_telp' => '082132560566',
            'alamat' => 'Perum Permata Regency 1 Blok 10/28, Perun Gpa, Ngijo, Kec. Karang Ploso, Kabupaten Malang, Jawa Timur 65152',
            'koordinat' => '-7.900044393286019, 112.6069118963316',
            'radius' => 100,

            "senin" => "08:00 - 16:00",
            "selasa" => "08:00 - 16:00",
            "rabu" => "08:00 - 16:00",
            "kamis" => "08:00 - 16:00",
            "jumat" => "08:00 - 16:00",
            "sabtu" => null,
            "minggu" => null,
            // jam istirahat
            "ji_senin" => "12:00 - 13:00",
            "ji_selasa" => "12:00 - 13:00",
            "ji_rabu" => "12:00 - 13:00",
            "ji_kamis" => "12:00 - 13:00",
            "ji_jumat" => "11:00 - 13:00",
            "ji_sabtu" => null,
            "ji_minggu" => null,
        ]);
    }
}
