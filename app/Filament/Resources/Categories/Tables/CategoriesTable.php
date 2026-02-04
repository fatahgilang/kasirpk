<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.resources.category.fields.name'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('slug')
                    ->label(__('app.resources.category.fields.slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                ColorColumn::make('color')
                    ->label(__('app.resources.category.fields.color')),
                
                TextColumn::make('products_count')
                    ->label(__('app.resources.category.fields.products_count'))
                    ->counts('products')
                    ->sortable(),
                
                IconColumn::make('is_active')
                    ->label(__('app.resources.category.fields.is_active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('created_at')
                    ->label(__('app.fields.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('app.resources.category.fields.is_active'))
                    ->placeholder(__('app.filters.all'))
                    ->trueLabel(__('app.fields.active'))
                    ->falseLabel(__('app.fields.inactive')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
