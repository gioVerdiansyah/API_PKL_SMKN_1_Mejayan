<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $response = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'jurusan');
            $data = json_decode($response->body());

            DB::beginTransaction();

            foreach ($data as $item) {
                $jurusan = new Jurusan;
                $jurusan->id = $item->id;
                $jurusan->jurusan = $item->jurusan;
                $jurusan->full_name = $item->full_name;
                $jurusan->gambar = config('app.admin_url') . $item->gambar;
                $jurusan->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
