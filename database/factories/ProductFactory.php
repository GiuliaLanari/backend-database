<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category_ids = Category::all()->pluck('id')->all();
        return [
          'title' =>fake()->words(rand(1,10), true),
          'picture' => null ,
          'summary' => null ,
          'description' => fake()->words(rand(15, 80), true),
          'price' => rand(0, 400),

          'category_id' => fake()->randomElement($category_ids),
        ];
        
    }
}
