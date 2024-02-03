<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'cottage_type_id' => fake()->numberBetween(1, 5),
            'period_id' => fake()->numberBetween(1, 10),
            'package_id' => fake()->numberBetween(1, 10),
            'rate' => fake()->numberBetween(1000, 100000),
            'is_active' => fake()->boolean
        ];
    }
}
