<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Category;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Penjualan per Kategori (Bulan Ini)';
    
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getData(): array
    {
        // Ambil data penjualan per kategori bulan ini
        $salesByCategory = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereMonth('transactions.created_at', now()->month)
            ->whereYear('transactions.created_at', now()->year)
            ->where('transactions.status', 'completed')
            ->select('categories.name', DB::raw('SUM(transaction_items.subtotal) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->get();

        // Jika tidak ada data, buat data dummy
        if ($salesByCategory->isEmpty()) {
            $categories = Category::all();
            $salesByCategory = $categories->map(function ($category) {
                return (object) [
                    'name' => $category->name,
                    'total' => rand(1000000, 10000000) // Data dummy untuk demo
                ];
            });
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => $salesByCategory->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#f59e0b', // amber
                        '#8b5cf6', // violet
                        '#10b981', // emerald
                        '#ef4444', // red
                        '#06b6d4', // cyan
                        '#84cc16', // lime
                        '#f97316', // orange
                        '#6366f1', // indigo
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $salesByCategory->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
