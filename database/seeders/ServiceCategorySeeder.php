<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        ServiceCategory::factory()
//            ->count(3)
//            ->sequence(
//                ['name' => 'Баня'],
//                ['name' => 'Летний инвентарь'],
//                ['name' => 'Зимний инвентарь'],
//            )
//        ->create();
        ServiceCategory::factory()
            ->state(['name' => 'Баня'])
            ->has(
                Service::factory()
                    ->count(4)
                    ->sequence(
                        [
                            'name' => 'Баня',
                            'attention' => 'Топится минимум на 2 часа, с третьего стоимость 1 000 руб./час',
                            'price' => '',
                            'price_per_hour' => '1500',
                            'price_per_day' => '-'
                        ],
                        [
                            'name' => 'Дрова (вязанка)',
                            'attention' => '',
                            'price' => '150',
                            'price_per_hour' => '-',
                            'price_per_day' => '-'
                        ],
                        [
                            'name' => 'Печь с дымоходом +казан + 2 вязанки дров',
                            'attention' => '',
                            'price' => '',
                            'price_per_hour' => '-',
                            'price_per_day' => '700'
                        ],
                        [
                            'name' => 'Набор настольных игр (шашки+шахматы+нарды)',
                            'attention' => 'Вносится залог  1 000 руб.',
                            'price' => '',
                            'price_per_hour' => '-',
                            'price_per_day' => 'Бесплатно'
                        ],
                    )
            )
            ->create();
        ServiceCategory::factory()
        ->state(['name' => 'Летний инвентарь'])
        ->has(
            Service::factory()
                ->count(6)
                ->sequence(
                    [
                        'name' => 'Катамаран',
                        'attention' => '',
                        'price' => '',
                        'price_per_hour' => '200',
                        'price_per_day' => '1000'
                    ],
                    [
                        'name' => 'Лодка',
                        'attention' => '',
                        'price' => '',
                        'price_per_hour' => '200',
                        'price_per_day' => '1000'
                    ],
                    [
                        'name' => 'Лодочный электромотор',
                        'attention' => '',
                        'price' => '',
                        'price_per_hour' => '200',
                        'price_per_day' => '1000'
                    ],
                    [
                        'name' => 'Бадминтон',
                        'attention' => '',
                        'price' => '',
                        'price_per_hour' => '200',
                        'price_per_day' => '800'
                    ],
                    [
                        'name' => 'Удочка',
                        'attention' => 'Вносится залог 1 000 руб.',
                        'price' => '',
                        'price_per_hour' => '100',
                        'price_per_day' => '500'
                    ],
                    [
                        'name' => 'Спортивная площадка',
                        'attention' => 'В наличии мячи, бесплатно⁠',
                        'price' => '',
                        'price_per_hour' => '-',
                        'price_per_day' => 'Бесплатно'
                    ],
                )
        )
        ->create();
        ServiceCategory::factory()
            ->state(['name' => 'Зимний инвентарь'])
            ->has(
                Service::factory()
                    ->count(4)
                    ->sequence(
                        [
                            'name' => 'Комплект для зимней рыбалки (бур, удочка, ящик)',
                            'attention' => 'Вносится залог 1 000 руб.',
                            'price' => '',
                            'price_per_hour' => '50',
                            'price_per_day' => '300'
                        ],
                        [
                            'name' => 'Ватрушка',
                            'attention' => '',
                            'price' => '',
                            'price_per_hour' => '150',
                            'price_per_day' => '800'
                        ],[
                        'name' => 'Клюшка детская',
                        'attention' => 'В наличии шайба, бесплатно',
                        'price' => '',
                        'price_per_hour' => '50',
                        'price_per_day' => '-'
                    ],[
                        'name' => 'Лыжи взрослые',
                        'attention' => '',
                        'price' => '',
                        'price_per_hour' => '-',
                        'price_per_day' => '300'
                    ],
                    )
            )
            ->create();
    }
}
