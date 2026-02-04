<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('app.resources.product.fields.code'))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('app.resources.product.fields.name'))
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('app.resources.product.fields.slug'))
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label(__('app.resources.product.fields.category'))
                    ->searchable(),
                TextColumn::make('unit.name')
                    ->label(__('app.resources.product.fields.unit'))
                    ->searchable(),
                TextColumn::make('stock_quantity')
                    ->label(__('app.resources.product.fields.stock_quantity'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('minimum_stock')
                    ->label(__('app.resources.product.fields.minimum_stock'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('purchase_price')
                    ->label(__('app.resources.product.fields.purchase_price'))
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('selling_price')
                    ->label(__('app.resources.product.fields.selling_price'))
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('wholesale_price')
                    ->label(__('app.resources.product.fields.wholesale_price'))
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('wholesale_min_qty')
                    ->label(__('app.resources.product.fields.wholesale_min_qty'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('barcode')
                    ->label(__('app.resources.product.fields.barcode'))
                    ->searchable(),
                TextColumn::make('brand')
                    ->label(__('app.resources.product.fields.brand'))
                    ->searchable(),
                TextColumn::make('location')
                    ->label(__('app.resources.product.fields.location'))
                    ->searchable(),
                TextColumn::make('expiry_date')
                    ->label(__('app.resources.product.fields.expiry_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('batch_number')
                    ->label(__('app.resources.product.fields.batch_number'))
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(__('app.resources.product.fields.is_active'))
                    ->boolean(),
                IconColumn::make('track_stock')
                    ->label(__('app.resources.product.fields.track_stock'))
                    ->boolean(),
                IconColumn::make('has_expiry')
                    ->label(__('app.resources.product.fields.has_expiry'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('app.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('app.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
