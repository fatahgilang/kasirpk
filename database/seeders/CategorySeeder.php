<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing categories
        Category::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $categories = [
            [
                'name' => 'Pakan Ayam',
                'slug' => 'pakan-ayam',
                'description' => 'Pakan untuk ayam broiler, layer, dan kampung',
                'icon' => 'heroicon-o-home',
                'color' => '#f59e0b',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Sapi',
                'slug' => 'pakan-sapi',
                'description' => 'Pakan untuk sapi potong dan perah',
                'icon' => 'heroicon-o-home',
                'color' => '#8b5cf6',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Kambing',
                'slug' => 'pakan-kambing',
                'description' => 'Pakan untuk kambing dan domba',
                'icon' => 'heroicon-o-home',
                'color' => '#10b981',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Bebek',
                'slug' => 'pakan-bebek',
                'description' => 'Pakan untuk bebek petelur dan pedaging',
                'icon' => 'heroicon-o-home',
                'color' => '#06b6d4',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Ikan',
                'slug' => 'pakan-ikan',
                'description' => 'Pakan untuk ikan lele, nila, dan gurame',
                'icon' => 'heroicon-o-home',
                'color' => '#3b82f6',
                'is_active' => true,
            ],
            [
                'name' => 'Obat-obatan',
                'slug' => 'obat-obatan',
                'description' => 'Obat-obatan dan antibiotik untuk ternak',
                'icon' => 'heroicon-o-beaker',
                'color' => '#ef4444',
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin & Suplemen',
                'slug' => 'vitamin-suplemen',
                'description' => 'Vitamin dan suplemen untuk ternak',
                'icon' => 'heroicon-o-heart',
                'color' => '#06b6d4',
                'is_active' => true,
            ],
            [
                'name' => 'Vaksin',
                'slug' => 'vaksin',
                'description' => 'Vaksin untuk pencegahan penyakit ternak',
                'icon' => 'heroicon-o-shield-check',
                'color' => '#84cc16',
                'is_active' => true,
            ],
            [
                'name' => 'Peralatan Kandang',
                'slug' => 'peralatan-kandang',
                'description' => 'Peralatan dan aksesoris kandang',
                'icon' => 'heroicon-o-wrench-screwdriver',
                'color' => '#6b7280',
                'is_active' => true,
            ],
            [
                'name' => 'Desinfektan',
                'slug' => 'desinfektan',
                'description' => 'Desinfektan dan pembersih kandang',
                'icon' => 'heroicon-o-beaker',
                'color' => '#14b8a6',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
        
        $this->command->info('✅ Categories seeded successfully');
    }
}
