<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensi>
 */
class AbsensiFactory extends Factory
{
    /**
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
            'status' => '1',
            'datang' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
