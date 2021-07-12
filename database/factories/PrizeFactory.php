<?php

namespace Database\Factories;

use App\Models\Prize;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrizeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prize::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'class' => $this->faker->text(255),
            'inventory' => $this->faker->randomNumber(0),
            'key' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}
