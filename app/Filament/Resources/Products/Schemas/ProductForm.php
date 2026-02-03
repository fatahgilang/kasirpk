<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('unit_id')
                    ->relationship('unit', 'name')
                    ->required(),
                TextInput::make('stock_quantity')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('minimum_stock')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('purchase_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('wholesale_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('wholesale_min_qty')
                    ->numeric(),
                TextInput::make('barcode'),
                TextInput::make('brand'),
                TextInput::make('location'),
                DatePicker::make('expiry_date'),
                TextInput::make('batch_number'),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('track_stock')
                    ->required(),
                Toggle::make('has_expiry')
                    ->required(),
                TextInput::make('images'),
                Textarea::make('usage_instructions')
                    ->columnSpanFull(),
            ]);
    }
}
