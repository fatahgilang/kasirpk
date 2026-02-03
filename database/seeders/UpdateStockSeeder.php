<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update beberapa produk untuk memiliki stok menipis
        Product::whereIn('id', [1, 2, 3])->update([
            'stock_quantity' => 5,
            'minimum_stock' => 10
        ]);

        // Update produk dengan stok habis
        Product::where('id', 4)->update([
            'stock_quantity' => 0,
            'minimum_stock' => 5
        ]);

        // Update produk dengan expiry date yang dekat
        Product::whereIn('id', [4, 5, 6])->update([
            'expiry_date' => now()->addDays(15),
            'has_expiry' => true
        ]);
    }
}
