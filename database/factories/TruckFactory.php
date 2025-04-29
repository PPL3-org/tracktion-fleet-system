<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Truck>
 */
class TruckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'=> (string) Str::uuid(),
            'user_id' => User::factory(),
            'plate_number' => strtoupper(fake()->bothify('B #### ??')),
            'model' => fake()->randomElement([
                'Hino Dutro',
                'Mitshubishi Fuso',
                'CDD Long Type'
            ]),
            'total_distance' => fake()->randomFloat(2, 100, 1200),
            'current_status' => 'tidak dalam pengiriman'
        ];
    }
}