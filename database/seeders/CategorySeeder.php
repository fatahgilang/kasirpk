<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pakan Ayam',
                'slug' => 'pakan-ayam',
                'description' => 'Pakan untuk ayam broiler, layer, dan kampung',
                'icon' => 'heroicon-o-home',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Pakan Sapi',
                'slug' => 'pakan-sapi',
                'description' => 'Pakan untuk sapi potong dan perah',
                'icon' => 'heroicon-o-home',
                'color' => '#8b5cf6',
            ],
            [
                'name' => 'Pakan Kambing',
                'slug' => 'pakan-kambing',
                'description' => 'Pakan untuk kambing dan domba',
                'icon' => 'heroicon-o-home',
                'color' => '#10b981',
            ],
            [
                'name' => 'Obat-obatan',
                'slug' => 'obat-obatan',
                'description' => 'Obat-obatan dan vitamin untuk ternak',
                'icon' => 'heroicon-o-beaker',
                'color' => '#ef4444',
            ],
            [
                'name' => 'Vitamin & Suplemen',
                'slug' => 'vitamin-suplemen',
                'description' => 'Vitamin dan suplemen untuk ternak',
                'icon' => 'heroicon-o-heart',
                'color' => '#06b6d4',
            ],
            [
                'name' => 'Vaksin',
                'slug' => 'vaksin',
                'description' => 'Vaksin untuk pencegahan penyakit ternak',
                'icon' => 'heroicon-o-shield-check',
                'color' => '#84cc16',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
