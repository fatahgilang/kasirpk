<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LowStockTable extends TableWidget
{
    protected static ?string $heading = 'Produk Stok Menipis';
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereColumn('stock_quantity', '<=', 'minimum_stock')
                    ->where('track_stock', true)
                    ->with(['category', 'unit'])
                    ->orderBy('stock_quantity', 'asc')
            )
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                    
                TextColumn::make('stock_quantity')
                    ->label('Stok Saat Ini')
                    ->numeric()
                    ->suffix(fn ($record) => ' ' . $record->unit->symbol)
                    ->color('danger'),
                    
                TextColumn::make('minimum_stock')
                    ->label('Stok Minimum')
                    ->numeric()
                    ->suffix(fn ($record) => ' ' . $record->unit->symbol)
                    ->color('warning'),
                    
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->color('gray'),
                    
                TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => 
                        $record->stock_quantity == 0 ? 'Habis' : 'Menipis'
                    )
                    ->badge()
                    ->color(fn ($record) => 
                        $record->stock_quantity == 0 ? 'danger' : 'warning'
                    ),
            ])
            ->defaultSort('stock_quantity', 'asc')
            ->paginated([5, 10, 25]);
    }
}
