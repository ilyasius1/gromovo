<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Period::factory()
            ->count(8)
            ->create();
        Period::factory()
            ->count(2)
            ->sequence(
                [
                    'name' => '1 мая',
                    'start' => '01.05.2024',
                    'end' => '01.05.2024',
                    'is_holiday' => true,
                ],
                [
                    'name' => '5 — 9 мая',
                    'start' => '05.05.2024',
                    'end' => '09.05.2024',
                    'is_holiday' => true,
                ]
            )
            ->create();
    }
}
