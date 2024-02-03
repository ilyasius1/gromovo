<?php

namespace Database\Seeders;

use App\Models\CottageType;
use App\Models\Period;
use App\Models\Price;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Price::factory()
            ->count(20)
            ->state(function (array $attributes) {
                $cottageType = CottageType::find($attributes['cottage_type_id']);
                $period = Period::find($attributes['period_id']);
                return [
                    'name' => $cottageType->name
                            . ' цена с '
                            . CarbonImmutable::create($period->start)->format('d.m.Y')
                            . ' по '
                            . CarbonImmutable::create($period->end)->format('d.m.Y')
                ];
            })
            ->create();
    }
}
