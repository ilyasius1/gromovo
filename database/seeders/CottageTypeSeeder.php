<?php

declare(strict_types=1);
namespace Database\Seeders;

use App\Models\Cottage;
use App\Models\CottageType;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CottageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cottagesPerType = 10;
        CottageType::factory()
            ->count(5)
            ->sequence(function (Sequence $sequence) use ($cottagesPerType){
                $firstIndex = ($sequence->index * $cottagesPerType) + 1;
                $lastIndex = $firstIndex + $cottagesPerType - 1;
                return [
                    'name' => "Коттеджи $firstIndex - $lastIndex"
                ];
            })
            ->has(
                Cottage::factory()
                    ->count($cottagesPerType)
                    ->state(function (array $attributes, CottageType $cottageType) {
                        return ['cottage_type_id' => $cottageType];
                    })
                    ->sequence(function (Sequence $sequence) {
                        return [
                            'name' => 'Громово-Коттедж №' . $sequence->index + 1,
                            'gallery_id' => function (array $attributes) {
                                return Gallery::factory()
                                    ->state(function () use ($attributes) {
                                        return [
                                            'name' => $attributes['name'],
                                            'name_eng' => Str::slug($attributes['name']),
                                            'description' => 'Фотографии ' . str_replace('Громово-Коттедж', 'Громово-Коттеджа', $attributes['name'])
                                        ];
                                    })
                                    ->has(Image::factory()->count(10));
                            },
                            'schema_gallery_id' =>  function (array $attributes) {
                                return Gallery::factory()
                                    ->state(function () use ($attributes) {
                                        return [
                                            'name' => $attributes['name'] . ' схема',
                                            'name_eng' => Str::slug($attributes['name'] . ' схема'),
                                            'description' => 'Cхема ' . str_replace('Громово-Коттедж', 'Громово-Коттеджа', $attributes['name'])
                                        ];
                                    })
                                    ->has(Image::factory()->count(5));
                            },
                            'summer_gallery_id' =>  function (array $attributes) {
                                return Gallery::factory()
                                    ->state(function () use ($attributes) {
                                        $name = $attributes['name'] . ' летом';
                                        return [
                                            'name' => $name,
                                            'name_eng' => Str::slug($name),
                                            'description' => 'Фотографии '
                                                . str_replace('Громово-Коттедж', 'Громово-Коттеджа', $name)
                                                . ' летом'
                                        ];
                                    })
                                    ->has(Image::factory()->count(10));;
                            },
                            'winter_gallery_id' =>  function (array $attributes) {
                                return Gallery::factory()
                                    ->state(function () use ($attributes) {
                                        $name = $attributes['name'] . ' зимой';
                                        return [
                                            'name' => $name,
                                            'name_eng' => Str::slug($name),
                                            'description' => 'Фотографии '
                                                . str_replace('Громово-Коттедж', 'Громово-Коттеджа', $name)
                                                . ' зимой',
                                        ];
                                    })
                                    ->has(Image::factory()->count(10));
                            },
                        ];
                    })
            )
            ->create();
    }
}
