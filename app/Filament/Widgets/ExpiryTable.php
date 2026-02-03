<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ExpiryTable extends TableWidget
{
    protected static ?string $heading = 'Produk Akan Kedaluwarsa';
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('has_expiry', true)
                    ->where('expiry_date', '<=', now()->addDays(90))
                    ->whereNotNull('expiry_date')
                    ->with(['category', 'unit'])
                    ->orderBy('expiry_date', 'asc')
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
                    
                TextColumn::make('batch_number')
                    ->label('No. Batch')
                    ->badge()
                    ->color('gray'),
                    
                TextColumn::make('expiry_date')
                    ->label('Tanggal Kedaluwarsa')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => 
                        $record->expiry_date->isPast() ? 'danger' :
                        ($record->expiry_date->diffInDays(now()) <= 30 ? 'warning' : 'success')
                    ),
                    
                TextColumn::make('days_to_expiry')
                    ->label('Sisa Hari')
                    ->getStateUsing(fn ($record) => 
                        $record->expiry_date->isPast() 
                            ? 'Kedaluwarsa' 
                            : $record->expiry_date->diffInDays(now()) . ' hari'
                    )
                    ->badge()
                    ->color(fn ($record) => 
                        $record->expiry_date->isPast() ? 'danger' :
                        ($record->expiry_date->diffInDays(now()) <= 30 ? 'warning' : 'success')
                    ),
                    
                TextColumn::make('stock_quantity')
                    ->label('Stok')
                    ->numeric()
                    ->suffix(fn ($record) => ' ' . $record->unit->symbol),
                    
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->color('info'),
                    
                TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => 
                        $record->expiry_date->isPast() ? 'Kedaluwarsa' :
                        ($record->expiry_date->diffInDays(now()) <= 30 ? 'Kritis' : 'Perhatian')
                    )
                    ->badge()
                    ->color(fn ($record) => 
                        $record->expiry_date->isPast() ? 'danger' :
                        ($record->expiry_date->diffInDays(now()) <= 30 ? 'warning' : 'info')
                    ),
            ])
            ->defaultSort('expiry_date', 'asc')
            ->paginated([5, 10, 25]);
    }
}
