<?php

namespace Database\Seeders;

use App\Models\Cottage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CottageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cottage::factory()
            ->count(10)
            ->sequence(fn (Sequence $sequence) => [ 'name' => 'Громово-Коттедж №' . $sequence->index])
            ->create();
    }
}
