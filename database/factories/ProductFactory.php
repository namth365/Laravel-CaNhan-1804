<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => rand(100, 200),
            'description' => $this->faker->text,
            'image' => $this->faker->image('thumbnail', 400, 300, null, false),
        ];
    }
}
