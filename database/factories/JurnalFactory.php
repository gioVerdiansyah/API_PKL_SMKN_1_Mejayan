<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurnal>
 */
class JurnalFactory extends Factory
{
    /**P
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->unique()->dateTimeInInterval(now(), '+30 days')->format('Y-m-d') . ' 00:00:00';
        return [
            'id' => fake()->uuid(),
            'user_id' => User::where('id', '077a4225-aa40-428f-b531-2af5d0919fe3')->first()->id,
            'kegiatan' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'bukti' => "jurnal/sGUhytoxKH9NWef1r5GUy7Adll5CuTtM3Kp91JrV.png",
            'status' => "1",
            'keterangan' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
