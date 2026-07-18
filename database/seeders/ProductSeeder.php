<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 50) as $i) {

            Product::create([
                'name' => "Product {$i}",
                'sku' => 'SKU-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'price' => rand(100, 5000),
                'stock_quantity' => rand(20, 150),
                'description' => "Description for Product {$i}",
                'status' => true,
            ]);
        }
    }
}
