<?php

namespace App\Filament\Resources\Transactions\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactionItems';

    protected static ?string $title = 'Item Transaksi';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Form tidak diperlukan karena ini read-only
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                TextColumn::make('product_code')
                    ->label('Kode Produk')
                    ->searchable(),
                    
                TextColumn::make('product_name')
                    ->label('Nama Produk')
                    ->searchable(),
                    
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->numeric(),
                    
                TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->money('IDR'),
                    
                TextColumn::make('discount_amount')
                    ->label('Diskon')
                    ->money('IDR'),
                    
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR'),
                    
                TextColumn::make('batch_number')
                    ->label('No. Batch')
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('expiry_date')
                    ->label('Kedaluwarsa')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tidak ada action karena read-only
            ])
            ->recordActions([
                // Tidak ada action karena read-only
            ])
            ->toolbarActions([
                // Tidak ada action karena read-only
            ]);
    }
}
