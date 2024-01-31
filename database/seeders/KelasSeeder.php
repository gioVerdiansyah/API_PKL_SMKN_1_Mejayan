<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $response = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'kelas');
            $data = json_decode($response->body());

            DB::beginTransaction();

            foreach ($data as $item) {
                $kelas = new Kelas;
                $kelas->id = $item->id;
                $kelas->kelas = $item->tingkatan . ' ' . $item->kelas;
                $kelas->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
