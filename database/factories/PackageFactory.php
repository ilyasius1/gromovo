<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ru_RU')->word(),
            'nights' => fake()->randomDigitNotNull(),
            'days_start' => fake()->numberBetween(1, 6),
            'days_end' => fake()->numberBetween(2, 7)
        ];
    }
}
