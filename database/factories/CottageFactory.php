<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cottage>
 */
class CottageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $floor1 = [];
        $floor2 = [];
        $floor3 = [];
        for ($i = 0; $i < 5; $i++) {
            $floor1[] = fake('ru_RU')->realText(100);
            $floor3[] = fake('ru_RU')->realText(100);
            $floor2[] = fake('ru_RU')->realText(100);
        }
        return [
            'name' => 'Громово-Коттедж №' . fake()->numberBetween(1, 300),
            'cottage_type_id' => fake()->numberBetween(1, 5),
            'description' => fake('ru_RU')->realText(),
            'area' => fake()->numberBetween(100, 200),
            'floors' => 2,
            'bedrooms' => fake()->numberBetween(1, 5),
            'single_beds' => fake()->numberBetween(0, 5),
            'double_beds' => fake()->numberBetween(0, 5),
            'additional_single_beds' => fake()->numberBetween(0, 5),
            'additional_double_beds' => fake()->numberBetween(0, 5),
            'bathrooms' => fake()->numberBetween(0, 5),
            'showers' => fake()->numberBetween(0, 5),
            'sauna' => fake()->boolean(),
            'fireplace' => fake()->boolean(),
            'floor1_features' => $floor1,
            'floor2_features' => $floor2,
            'floor3_features' => $floor3,
            'is_active' => false
        ];
    }

    public function suspended(): CottageFactory
    {
        return $this->state(function (array $attributes) {
            $floor1 = [];
            $floor2 = [];
            $floor3 = [];
            for ($i = 0; $i < 5; $i++) {
                $floor1[] = fake('ru_RU')->realText(100);
                $floor3[] = fake('ru_RU')->realText(100);
                $floor2[] = fake('ru_RU')->realText(100);
            }
            return [
                'floor1_features' => $floor1,
                'floor2_features' => $floor2,
                'floor3_features' => $floor3,
            ];
        });
    }
}
