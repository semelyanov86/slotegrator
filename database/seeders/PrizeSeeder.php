<?php

namespace Database\Seeders;

use App\Models\Prize;
use Illuminate\Database\Seeder;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prizes = [
            [
                'name' => 'Денежный',
                'class' => 'App\Services\MoneyPrize',
                'inventory' => 1000,
                'key' => 'MONEY',
                'description' => 'Money'
            ],
            [
                'name' => 'Бонусные баллы',
                'class' => 'App\Services\BonusPrize',
                'inventory' => null,
                'key' => 'Bonus',
                'description' => 'Bonus'
            ],
            [
                'name' => 'Физический предмет',
                'class' => 'App\Services\PhyzicPrize',
                'inventory' => 100,
                'key' => 'Physic',
                'description' => 'Physic'
            ],
        ];
        foreach ($prizes as $prize) {
            Prize::create($prize);
        }
    }
}
