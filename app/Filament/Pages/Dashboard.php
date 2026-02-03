<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Kasir Pakan Ternak';

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 3,
            'lg' => 4,
            'xl' => 6,
            '2xl' => 8,
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardStats::class,
            \App\Filament\Widgets\SalesTrendChart::class,
            \App\Filament\Widgets\SalesChart::class,
            \App\Filament\Widgets\LowStockTable::class,
            \App\Filament\Widgets\ExpiryTable::class,
            \App\Filament\Widgets\RecentTransactions::class,
        ];
    }
}