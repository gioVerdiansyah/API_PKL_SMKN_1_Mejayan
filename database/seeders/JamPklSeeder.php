<?php

namespace Database\Seeders;

use App\Models\DetailPkl;
use App\Models\JamPkl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JamPklSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JamPkl::create([
            'detail_pkl_id' => DetailPkl::first()->id,
            "senin"=> "08:00 - 16:00",
            "selasa"=> "08:00 - 16:00",
            "rabu"=> "08:00 - 16:00",
            "kamis"=> "08:00 - 16:00",
            "jumat"=> "08:00 - 16:00",
            "saptu"=> null,
            "minggu"=> null,
            // jam istirahat
            "ji_senin" => "12:00 - 13:00",
            "ji_selasa" => "12:00 - 13:00",
            "ji_rabu" => "12:00 - 13:00",
            "ji_kamis" => "12:00 - 13:00",
            "ji_jumat" => "11:00 - 13:00",
            "ji_saptu" => null,
            "ji_minggu" => null,
        ]);
    }
}
