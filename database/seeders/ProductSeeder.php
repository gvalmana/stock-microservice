<?php

namespace Database\Seeders;

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
        $data= [];
        foreach (Product::getNamesConstants() as $key => $value) {
            $data['name'] = $value;
            Product::updateOrCreate($data);
        }
    }
}
