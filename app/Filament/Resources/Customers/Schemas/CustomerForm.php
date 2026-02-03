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
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('livestock_type'),
                TextInput::make('livestock_count')
                    ->numeric(),
                Select::make('customer_type')
                    ->options(['retail' => 'Retail', 'wholesale' => 'Wholesale', 'reseller' => 'Reseller'])
                    ->default('retail')
                    ->required(),
                TextInput::make('credit_limit')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('current_debt')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('payment_term_days')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('loyalty_points')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_purchases')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DatePicker::make('last_purchase_date'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('allow_credit')
                    ->required(),
            ]);
    }
}
