<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and units
        $pakanAyam = Category::where('slug', 'pakan-ayam')->first();
        $pakanSapi = Category::where('slug', 'pakan-sapi')->first();
        $obat = Category::where('slug', 'obat-obatan')->first();
        $vitamin = Category::where('slug', 'vitamin-suplemen')->first();
        
        $kg = Unit::where('symbol', 'kg')->first();
        $botol = Unit::where('symbol', 'btl')->first();
        $tablet = Unit::where('symbol', 'tab')->first();
        $sachet = Unit::where('symbol', 'sct')->first();

        $products = [
            // Pakan Ayam
            [
                'code' => 'PAK-001',
                'name' => 'Pakan Ayam Broiler Starter',
                'slug' => 'pakan-ayam-broiler-starter',
                'description' => 'Pakan ayam broiler umur 0-3 minggu',
                'category_id' => $pakanAyam->id,
                'unit_id' => $kg->id,
                'stock_quantity' => 500,
                'minimum_stock' => 50,
                'purchase_price' => 8500,
                'selling_price' => 9500,
                'wholesale_price' => 9000,
                'wholesale_min_qty' => 100,
                'brand' => 'Charoen Pokphand',
                'location' => 'Rak A1',
                'track_stock' => true,
            ],
            [
                'code' => 'PAK-002',
                'name' => 'Pakan Ayam Layer',
                'slug' => 'pakan-ayam-layer',
                'description' => 'Pakan ayam petelur dewasa',
                'category_id' => $pakanAyam->id,
                'unit_id' => $kg->id,
                'stock_quantity' => 750,
                'minimum_stock' => 75,
                'purchase_price' => 7800,
                'selling_price' => 8800,
                'wholesale_price' => 8300,
                'wholesale_min_qty' => 200,
                'brand' => 'Japfa',
                'location' => 'Rak A2',
                'track_stock' => true,
            ],
            
            // Pakan Sapi
            [
                'code' => 'PAK-003',
                'name' => 'Konsentrat Sapi Perah',
                'slug' => 'konsentrat-sapi-perah',
                'description' => 'Konsentrat untuk sapi perah produktif',
                'category_id' => $pakanSapi->id,
                'unit_id' => $kg->id,
                'stock_quantity' => 1000,
                'minimum_stock' => 100,
                'purchase_price' => 4500,
                'selling_price' => 5200,
                'wholesale_price' => 4800,
                'wholesale_min_qty' => 500,
                'brand' => 'Cargill',
                'location' => 'Rak B1',
                'track_stock' => true,
            ],
            
            // Obat-obatan
            [
                'code' => 'OBT-001',
                'name' => 'Antibiotik Ternak',
                'slug' => 'antibiotik-ternak',
                'description' => 'Antibiotik untuk pengobatan infeksi ternak',
                'category_id' => $obat->id,
                'unit_id' => $botol->id,
                'stock_quantity' => 25,
                'minimum_stock' => 5,
                'purchase_price' => 45000,
                'selling_price' => 55000,
                'brand' => 'Medion',
                'location' => 'Rak C1',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(18),
                'batch_number' => 'MED2024001',
                'usage_instructions' => 'Dosis: 1ml per 10kg berat badan, 2x sehari',
                'track_stock' => true,
            ],
            
            // Vitamin
            [
                'code' => 'VIT-001',
                'name' => 'Vitamin B Complex',
                'slug' => 'vitamin-b-complex',
                'description' => 'Vitamin B kompleks untuk ternak',
                'category_id' => $vitamin->id,
                'unit_id' => $tablet->id,
                'stock_quantity' => 500,
                'minimum_stock' => 50,
                'purchase_price' => 500,
                'selling_price' => 750,
                'wholesale_price' => 650,
                'wholesale_min_qty' => 100,
                'brand' => 'Sanbe',
                'location' => 'Rak C2',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(24),
                'batch_number' => 'SAN2024001',
                'usage_instructions' => '1 tablet per hari dicampur pakan',
                'track_stock' => true,
            ],
            [
                'code' => 'VIT-002',
                'name' => 'Elektrolit Sachet',
                'slug' => 'elektrolit-sachet',
                'description' => 'Elektrolit untuk mengatasi dehidrasi ternak',
                'category_id' => $vitamin->id,
                'unit_id' => $sachet->id,
                'stock_quantity' => 200,
                'minimum_stock' => 20,
                'purchase_price' => 2500,
                'selling_price' => 3500,
                'wholesale_price' => 3000,
                'wholesale_min_qty' => 50,
                'brand' => 'Romindo',
                'location' => 'Rak C3',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(12),
                'batch_number' => 'ROM2024001',
                'usage_instructions' => '1 sachet untuk 10 liter air minum',
                'track_stock' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
