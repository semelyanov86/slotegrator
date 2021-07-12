<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
          [
              'name' => 'Пакетик',
              'inventory' => 10
          ],
            [
                'name' => 'Валенки',
                'inventory' => 20
            ],
            [
                'name' => 'Футболка',
                'inventory' => 30
            ]
        ];
        Product::insert($products);
    }
}
