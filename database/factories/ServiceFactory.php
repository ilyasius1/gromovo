<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'service_category_id' => fake()->numberBetween(1, 5),
            'attention' => fake('ru_RU')->realText(100),
            'price' => fake()->numberBetween(1, 300),
            'price_per_hour' => fake()->numberBetween(1, 300),
            'price_per_day' => fake()->numberBetween(1, 300)
        ];
    }
}
