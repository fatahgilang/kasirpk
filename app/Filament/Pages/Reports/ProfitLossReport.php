<?php

namespace App\Filament\Pages\Reports;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Session;

class ProfitLossReport extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Laba Rugi';

    public static function getNavigationLabel(): string
    {
        return __('Laporan Laba Rugi');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Laporan');
    }

    public function getHeading(): string
    {
        return static::getTitle();
    }

    public function getView(): string
    {
        return 'filament.pages.reports.profit-loss-report';
    }

    protected static ?string $title = 'Laporan Laba Rugi';

    protected static ?int $navigationSort = 4;

    #[Rule('nullable|date')]
    #[Url]
    #[Session]
    public ?string $startDate = null;
    
    #[Rule('nullable|date')]
    #[Url]
    #[Session]
    public ?string $endDate = null;

    #[On('refresh-report')]
    public function refreshReport()
    {
        $this->generateReport();
    }

    #[Computed]
    public array $reportData = [];

    public function mount(): void
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->generateReport();
    }

    public function generateReport(): void
    {
        $startDate = $this->startDate ? Carbon::parse($this->startDate)->startOfDay() : null;
        $endDate = $this->endDate ? Carbon::parse($this->endDate)->endOfDay() : null;

        // Calculate revenue (total sales)
        $revenueQuery = Transaction::where('status', 'completed')
            ->where('payment_status', 'paid');

        if ($startDate) {
            $revenueQuery->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $revenueQuery->where('created_at', '<=', $endDate);
        }

        $totalRevenue = $revenueQuery->sum('total_amount');

        // Calculate cost of goods sold (COGS)
        $cogsQuery = DB::table('transaction_items as ti')
            ->join('transactions as t', 'ti.transaction_id', '=', 't.id')
            ->join('products as p', 'ti.product_id', '=', 'p.id')
            ->where('t.status', 'completed')
            ->where('t.payment_status', 'paid');

        if ($startDate) {
            $cogsQuery->where('t.created_at', '>=', $startDate);
        }

        if ($endDate) {
            $cogsQuery->where('t.created_at', '<=', $endDate);
        }

        // For more accurate COGS calculation, we need to consider the conversion from transaction quantity to base unit
        // The transaction stores quantities in base unit (grams), so we need to calculate the cost based on purchase price
        // considering the unit conversion
        $totalCogs = $cogsQuery->selectRaw('SUM(ti.quantity * p.purchase_price) as total_cogs')->value('total_cogs') ?? 0;

        // Calculate expenses (if you have expense tracking, you can add here)
        $totalExpenses = 0; // Placeholder - add actual expense calculation if available

        // Calculate profit/loss
        $grossProfit = $totalRevenue - $totalCogs;
        $netProfit = $grossProfit - $totalExpenses;

        $this->reportData = [
            'period' => [
                'start' => $startDate?->format('d/m/Y'),
                'end' => $endDate?->format('d/m/Y'),
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'formatted' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            ],
            'cost_of_goods_sold' => [
                'total' => $totalCogs,
                'formatted' => 'Rp ' . number_format($totalCogs, 0, ',', '.'),
            ],
            'gross_profit' => [
                'total' => $grossProfit,
                'formatted' => 'Rp ' . number_format($grossProfit, 0, ',', '.'),
            ],
            'expenses' => [
                'total' => $totalExpenses,
                'formatted' => 'Rp ' . number_format($totalExpenses, 0, ',', '.'),
            ],
            'net_profit' => [
                'total' => $netProfit,
                'formatted' => 'Rp ' . number_format($netProfit, 0, ',', '.'),
            ],
            'profit_margin' => $totalRevenue > 0 ? round(($netProfit / $totalRevenue) * 100, 2) : 0,
        ];
        
        // Force Livewire to recognize the property change
        $this->dispatch('refresh-report');
    }

    public function updatedStartDate(): void
    {
        $this->generateReport();
    }

    public function updatedEndDate(): void
    {
        $this->generateReport();
    }

    public function exportToPdf(): void
    {
        // Implementation for PDF export would go here
        // This requires additional setup with a PDF library like Barryvdh\Laravel-dompdf
    }
}