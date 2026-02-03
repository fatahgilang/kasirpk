<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('livestock_type')
                    ->searchable(),
                TextColumn::make('livestock_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('customer_type')
                    ->badge(),
                TextColumn::make('credit_limit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current_debt')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_term_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('loyalty_points')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_purchases')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_purchase_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('allow_credit')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
