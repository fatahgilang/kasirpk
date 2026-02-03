<?php

namespace Database\Seeders;

use App\Models\ProductUnit;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductUnitSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $units = Unit::all();
        
        // Unit mapping untuk berbagai produk
        $unitMappings = [
            'kg' => ['krg', 'sak', 'ton'], // Kilogram bisa dijual dalam karung, sak, atau ton
            'btl' => ['pcs'], // Botol bisa dijual satuan
            'tab' => ['strip', 'pcs'], // Tablet bisa dijual per strip atau satuan
            'sct' => ['pcs'], // Sachet bisa dijual satuan
        ];

        foreach ($products as $product) {
            $baseUnit = $product->unit;
            
            // Tambahkan unit alternatif berdasarkan unit dasar
            if (isset($unitMappings[$baseUnit->symbol])) {
                foreach ($unitMappings[$baseUnit->symbol] as $altUnitSymbol) {
                    $altUnit = $units->where('symbol', $altUnitSymbol)->first();
                    
                    if ($altUnit) {
                        // Tentukan konversi dan harga berdasarkan unit
                        $conversionFactor = match($altUnitSymbol) {
                            'krg' => 50, // 1 karung = 50 kg
                            'sak' => 25, // 1 sak = 25 kg
                            'ton' => 1000, // 1 ton = 1000 kg
                            'strip' => 10, // 1 strip = 10 tablet
                            'pcs' => 1, // 1 pcs = 1 unit
                            default => 1,
                        };
                        
                        // Hitung harga berdasarkan konversi
                        $sellingPrice = $product->selling_price * $conversionFactor;
                        $purchasePrice = $product->purchase_price * $conversionFactor;
                        
                        // Berikan diskon untuk pembelian dalam jumlah besar
                        if ($conversionFactor > 1) {
                            $discountPercent = match($altUnitSymbol) {
                                'krg', 'sak' => 0.05, // 5% diskon
                                'ton' => 0.10, // 10% diskon
                                'strip' => 0.03, // 3% diskon
                                default => 0,
                            };
                            
                            $sellingPrice = $sellingPrice * (1 - $discountPercent);
                        }

                        ProductUnit::create([
                            'product_id' => $product->id,
                            'unit_id' => $altUnit->id,
                            'conversion_factor' => $conversionFactor,
                            'purchase_price' => $purchasePrice,
                            'selling_price' => $sellingPrice,
                            'wholesale_price' => $sellingPrice * 0.95, // 5% lebih murah untuk grosir
                            'wholesale_min_qty' => max(1, intval($conversionFactor / 10)),
                            'is_default' => false,
                        ]);
                    }
                }
            }
        }

        // Tambahkan beberapa unit khusus untuk produk tertentu
        $specialMappings = [
            'Pakan Ayam Broiler Starter' => [
                ['unit' => 'krg', 'factor' => 50, 'discount' => 0.05],
                ['unit' => 'sak', 'factor' => 25, 'discount' => 0.03],
            ],
            'Konsentrat Sapi Perah' => [
                ['unit' => 'krg', 'factor' => 50, 'discount' => 0.05],
                ['unit' => 'ton', 'factor' => 1000, 'discount' => 0.10],
            ],
            'Vitamin B Complex' => [
                ['unit' => 'strip', 'factor' => 10, 'discount' => 0.03],
                ['unit' => 'btl', 'factor' => 100, 'discount' => 0.08],
            ],
        ];

        foreach ($specialMappings as $productName => $mappings) {
            $product = $products->where('name', $productName)->first();
            
            if ($product) {
                foreach ($mappings as $mapping) {
                    $unit = $units->where('symbol', $mapping['unit'])->first();
                    
                    if ($unit && !ProductUnit::where('product_id', $product->id)->where('unit_id', $unit->id)->exists()) {
                        $sellingPrice = $product->selling_price * $mapping['factor'] * (1 - $mapping['discount']);
                        
                        ProductUnit::create([
                            'product_id' => $product->id,
                            'unit_id' => $unit->id,
                            'conversion_factor' => $mapping['factor'],
                            'purchase_price' => $product->purchase_price * $mapping['factor'],
                            'selling_price' => $sellingPrice,
                            'wholesale_price' => $sellingPrice * 0.95,
                            'wholesale_min_qty' => max(1, intval($mapping['factor'] / 20)),
                            'is_default' => false,
                        ]);
                    }
                }
            }
        }
    }
}