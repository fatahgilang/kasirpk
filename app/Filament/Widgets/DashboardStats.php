<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DashboardStats extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        // Hitung statistik
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'minimum_stock')->count();
        $expiringProducts = Product::where('has_expiry', true)
            ->where('expiry_date', '<=', now()->addDays(30))
            ->count();
        
        $totalCustomers = Customer::where('is_active', true)->count();
        $creditCustomers = Customer::where('allow_credit', true)
            ->where('current_debt', '>', 0)
            ->count();
        
        $todaySales = Transaction::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');
        
        $monthSales = Transaction::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('total_amount');

        return [
            Stat::make('Total Produk', $totalProducts)
                ->description('Produk aktif dalam sistem')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
                
            Stat::make('Stok Menipis', $lowStockProducts)
                ->description('Produk dengan stok di bawah minimum')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockProducts > 0 ? 'warning' : 'success'),
                
            Stat::make('Akan Kedaluwarsa', $expiringProducts)
                ->description('Produk kedaluwarsa dalam 30 hari')
                ->descriptionIcon('heroicon-m-clock')
                ->color($expiringProducts > 0 ? 'danger' : 'success'),
                
            Stat::make('Total Pelanggan', $totalCustomers)
                ->description('Pelanggan aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
                
            Stat::make('Piutang Aktif', $creditCustomers)
                ->description('Pelanggan dengan piutang')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($creditCustomers > 0 ? 'warning' : 'success'),
                
            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($todaySales, 0, ',', '.'))
                ->description('Total penjualan hari ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($monthSales, 0, ',', '.'))
                ->description('Total penjualan bulan ' . now()->format('F'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}
