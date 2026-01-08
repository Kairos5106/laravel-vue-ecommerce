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
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'Noise-cancelling over-ear headphones.',
                'price' => 199.99,
                'quantity' => 50,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit with blue switches.',
                'price' => 89.50,
                'quantity' => 30,
            ],
            [
                'name' => 'Gaming Mouse',
                'description' => '16000 DPI ergonomic gaming mouse.',
                'price' => 55.00,
                'quantity' => 100,
            ],
            [
                'name' => 'UltraWide Monitor',
                'description' => '34-inch curved productivity monitor.',
                'price' => 450.00,
                'quantity' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
