<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.resources.unit.fields.name'))
                    ->searchable(),
                TextColumn::make('symbol')
                    ->label(__('app.resources.unit.fields.symbol'))
                    ->searchable(),
                IconColumn::make('is_base_unit')
                    ->label(__('app.resources.unit.fields.is_base_unit'))
                    ->boolean(),
                TextColumn::make('conversion_factor')
                    ->label(__('app.resources.unit.fields.conversion_factor'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('app.resources.unit.fields.is_active'))
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
