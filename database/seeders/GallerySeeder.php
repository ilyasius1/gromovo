<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gallery::factory()
            ->count(10)
            ->has(
                Image::factory()
                ->count(5)
                    ->state(function (array $attributes, Gallery $gallery) {
                        return ['gallery_id' => $gallery->id];
                    }),
                'images'
            )
//            ->state(new Sequence(
//                fn (Sequence $sequence) => [ 'main_image_id' => $sequence->images->first()]
//            ))
            ->create();
    }
}
