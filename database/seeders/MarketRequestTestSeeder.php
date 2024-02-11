<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\MarketRequest;
use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketRequestTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(ProductSeeder::class);
        $order = OrderRegister::factory()->create();
        $ingredients = Ingredient::factory(2)->create([
            'order_register_id' => $order->id,
            'quantity' => 1,
            'product_id' => Product::first()->id,
        ]);
        foreach ($ingredients as $ingredient) {
            MarketRequest::factory()->create([
                'product_id' => $ingredient->product_id,
                'quantity_sold' => random_int(1, 5),
            ]);
        }
    }
}
