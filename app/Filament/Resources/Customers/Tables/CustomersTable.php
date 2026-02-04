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
                    ->label(__('app.resources.customer.fields.code'))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('app.resources.customer.fields.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('app.resources.customer.fields.email'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('app.resources.customer.fields.phone'))
                    ->searchable(),
                TextColumn::make('livestock_type')
                    ->label(__('app.resources.customer.fields.livestock_type'))
                    ->searchable(),
                TextColumn::make('livestock_count')
                    ->label(__('app.resources.customer.fields.livestock_count'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('customer_type')
                    ->label(__('app.resources.customer.fields.customer_type'))
                    ->badge(),
                TextColumn::make('credit_limit')
                    ->label(__('app.resources.customer.fields.credit_limit'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current_debt')
                    ->label(__('app.resources.customer.fields.current_debt'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_term_days')
                    ->label(__('app.resources.customer.fields.payment_term_days'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('loyalty_points')
                    ->label(__('app.resources.customer.fields.loyalty_points'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_purchases')
                    ->label(__('app.resources.customer.fields.total_purchases'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_purchase_date')
                    ->label(__('app.resources.customer.fields.last_purchase_date'))
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('app.resources.customer.fields.is_active'))
                    ->boolean(),
                IconColumn::make('allow_credit')
                    ->label(__('app.resources.customer.fields.allow_credit'))
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
