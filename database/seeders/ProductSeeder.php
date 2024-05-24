<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(10)->create();

        $products = Product::all()->all();
        $cart_ids = Cart::all()->pluck('id')->all();
        $order_ids = Order::all()->pluck('id')->all();

        foreach ($products as $product) {
            
                $carts_for_client = fake()->randomElements($cart_ids, rand(0, min(20, count($cart_ids))));
                foreach ($carts_for_client as $cart_id) {
                    $product->carts()->attach($cart_id, ['quantity' => rand(0, 31)]);
            }
                $orders_for_client = fake()->randomElements($order_ids, rand(0, min(50, count($order_ids))));
                foreach ($orders_for_client as $order_id) {
                    $product->orders()->attach($order_id, ['price' => rand(5, 2000), 'quantity' => rand(0, 31) ]);
                
            }
        }
    }
}
