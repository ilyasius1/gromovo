<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Period>
 */
class PeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ru_RU')->monthName() . ' - ' . fake('ru_RU')->monthName(),
            'start' => fake()->date(),
            'end' => fake()->date(),
            'is_holiday' => fake()->boolean,
            'is_active' => fake()->boolean
        ];
    }
}
