<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing units
        Unit::truncate();
        
        $units = [
            // Unit Berat
            [
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'description' => 'Unit berat dasar',
                'is_base_unit' => true,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Gram',
                'symbol' => 'g',
                'description' => 'Unit berat kecil',
                'is_base_unit' => false,
                'conversion_factor' => 0.001, // 1 gram = 0.001 kg
            ],
            [
                'name' => 'Ton',
                'symbol' => 'ton',
                'description' => 'Unit berat besar',
                'is_base_unit' => false,
                'conversion_factor' => 1000, // 1 ton = 1000 kg
            ],
            
            // Unit Kemasan
            [
                'name' => 'Karung',
                'symbol' => 'krg',
                'description' => 'Kemasan karung (biasanya 50kg)',
                'is_base_unit' => false,
                'conversion_factor' => 50, // 1 karung = 50 kg (default)
            ],
            [
                'name' => 'Sak',
                'symbol' => 'sak',
                'description' => 'Kemasan sak',
                'is_base_unit' => false,
                'conversion_factor' => 25, // 1 sak = 25 kg (default)
            ],
            
            // Unit Volume
            [
                'name' => 'Liter',
                'symbol' => 'L',
                'description' => 'Unit volume',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Mililiter',
                'symbol' => 'ml',
                'description' => 'Unit volume kecil',
                'is_base_unit' => false,
                'conversion_factor' => 0.001, // 1 ml = 0.001 L
            ],
            
            // Unit Kemasan Obat
            [
                'name' => 'Botol',
                'symbol' => 'btl',
                'description' => 'Kemasan botol',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Tablet',
                'symbol' => 'tab',
                'description' => 'Unit tablet/pil',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Kapsul',
                'symbol' => 'kps',
                'description' => 'Unit kapsul',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Sachet',
                'symbol' => 'sct',
                'description' => 'Kemasan sachet',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Strip',
                'symbol' => 'strip',
                'description' => 'Kemasan strip (biasanya 10 tablet)',
                'is_base_unit' => false,
                'conversion_factor' => 10,
            ],
            
            // Unit Lainnya
            [
                'name' => 'Pieces',
                'symbol' => 'pcs',
                'description' => 'Unit satuan',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
        ];

        foreach ($units as $unitData) {
            Unit::create($unitData);
        }
        
        $this->command->info('✅ Units seeded successfully');
    }
}
