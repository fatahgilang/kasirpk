<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_number')
                    ->label(__('app.resources.transaction.fields.transaction_number'))
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('customer.name')
                    ->label(__('app.resources.transaction.fields.customer'))
                    ->default('Umum')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('user.name')
                    ->label(__('app.resources.transaction.fields.cashier'))
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('total_amount')
                    ->label(__('app.resources.transaction.fields.total_amount'))
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('payment_method')
                    ->label(__('app.resources.transaction.fields.payment_method'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'transfer' => 'info',
                        'qris' => 'warning',
                        'credit' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => __('app.resources.transaction.payment_methods.cash'),
                        'transfer' => __('app.resources.transaction.payment_methods.transfer'),
                        'qris' => __('app.resources.transaction.payment_methods.qris'),
                        'credit' => __('app.resources.transaction.payment_methods.credit'),
                        default => $state,
                    }),
                    
                TextColumn::make('payment_status')
                    ->label(__('app.resources.transaction.fields.payment_status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'partial' => 'warning',
                        'unpaid' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => __('app.resources.transaction.payment_statuses.paid'),
                        'partial' => __('app.resources.transaction.payment_statuses.partial'),
                        'unpaid' => __('app.resources.transaction.payment_statuses.unpaid'),
                        default => $state,
                    }),
                    
                TextColumn::make('status')
                    ->label(__('app.resources.transaction.fields.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'cancelled' => 'warning',
                        'refunded' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'completed' => __('app.resources.transaction.statuses.completed'),
                        'cancelled' => __('app.resources.transaction.statuses.cancelled'),
                        'refunded' => __('app.resources.transaction.statuses.refunded'),
                        default => $state,
                    }),
                    
                TextColumn::make('created_at')
                    ->label(__('app.resources.transaction.fields.transaction_date'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                    
                TextColumn::make('due_date')
                    ->label(__('app.resources.transaction.fields.due_date'))
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('payment_method')
                    ->label(__('app.resources.transaction.fields.payment_method'))
                    ->options([
                        'cash' => __('app.resources.transaction.payment_methods.cash'),
                        'transfer' => __('app.resources.transaction.payment_methods.transfer'),
                        'qris' => __('app.resources.transaction.payment_methods.qris'),
                        'credit' => __('app.resources.transaction.payment_methods.credit'),
                    ]),
                    
                SelectFilter::make('payment_status')
                    ->label(__('app.resources.transaction.fields.payment_status'))
                    ->options([
                        'paid' => __('app.resources.transaction.payment_statuses.paid'),
                        'partial' => __('app.resources.transaction.payment_statuses.partial'),
                        'unpaid' => __('app.resources.transaction.payment_statuses.unpaid'),
                    ]),
                    
                SelectFilter::make('status')
                    ->label(__('app.resources.transaction.fields.status'))
                    ->options([
                        'completed' => __('app.resources.transaction.statuses.completed'),
                        'cancelled' => __('app.resources.transaction.statuses.cancelled'),
                        'refunded' => __('app.resources.transaction.statuses.refunded'),
                    ]),
                    
                Filter::make('today')
                    ->label(__('app.filters.today'))
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
                    
                Filter::make('this_week')
                    ->label(__('app.filters.this_week'))
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
                    
                    
                Filter::make('this_month')
                    ->label(__('app.filters.this_month'))
                    ->query(fn (Builder $query): Builder => $query->whereMonth('created_at', now()->month)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
