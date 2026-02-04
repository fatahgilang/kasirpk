<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('app.resources.customer.fields.code'))
                    ->required(),
                TextInput::make('name')
                    ->label(__('app.resources.customer.fields.name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('app.resources.customer.fields.email'))
                    ->email(),
                TextInput::make('phone')
                    ->label(__('app.resources.customer.fields.phone'))
                    ->tel(),
                Textarea::make('address')
                    ->label(__('app.resources.customer.fields.address'))
                    ->columnSpanFull(),
                TextInput::make('livestock_type')
                    ->label(__('app.resources.customer.fields.livestock_type')),
                TextInput::make('livestock_count')
                    ->label(__('app.resources.customer.fields.livestock_count'))
                    ->numeric(),
                Select::make('customer_type')
                    ->label(__('app.resources.customer.fields.customer_type'))
                    ->options([
                        'retail' => __('app.resources.customer.types.retail'),
                        'wholesale' => __('app.resources.customer.types.wholesale'),
                        'reseller' => __('app.resources.customer.types.reseller')
                    ])
                    ->default('retail')
                    ->required(),
                TextInput::make('credit_limit')
                    ->label(__('app.resources.customer.fields.credit_limit'))
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                TextInput::make('current_debt')
                    ->label(__('app.resources.customer.fields.current_debt'))
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                TextInput::make('payment_term_days')
                    ->label(__('app.resources.customer.fields.payment_term_days'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('loyalty_points')
                    ->label(__('app.resources.customer.fields.loyalty_points'))
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_purchases')
                    ->label(__('app.resources.customer.fields.total_purchases'))
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                DatePicker::make('last_purchase_date')
                    ->label(__('app.resources.customer.fields.last_purchase_date')),
                Toggle::make('is_active')
                    ->label(__('app.resources.customer.fields.is_active'))
                    ->required(),
                Toggle::make('allow_credit')
                    ->label(__('app.resources.customer.fields.allow_credit'))
                    ->required(),
            ]);
    }
}
