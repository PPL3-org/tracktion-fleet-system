<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shipment_id' => Shipment::factory(),
            'problem_type' => fake()->randomElement(['kemacetan', 'kecelakaan', 'masalah kendaraan', 'lainnya']),
            'problem_description' => fake()->paragraph(1)
        ];
    }
}
