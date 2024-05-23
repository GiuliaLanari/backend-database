<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_ids = User::all()->pluck('id')->all();
        $product_ids = Product::all()->pluck('id')->all();

        return [
          'rating' => rand(0, 5),
          'comment' =>fake()->words(rand(10, 50), true) ,
          'user_id' => fake()->randomElement($user_ids),
          'product_id' => fake()->randomElement($product_ids),
        
        ];
    }
}
