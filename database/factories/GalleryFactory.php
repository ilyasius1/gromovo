<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
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
            'name_eng' => fake('en_US')->word(),
            'description' => fake('ru_RU')->realText(100)
        ];
    }

//    /**
//     * Configure the factory.
//     *
//     * @return GalleryFactory
//     */
//    public function configure(): GalleryFactory
//    {
//        return $this->afterCreating(function (Gallery $gallery) {
//            $image = $gallery->images()->get()->random();
//            $gallery->main_image_id = $image->id;
//            $gallery->save();
//        });
//    }

}
