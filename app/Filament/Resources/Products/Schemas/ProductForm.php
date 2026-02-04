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
                    ->label(__('app.resources.product.fields.code'))
                    ->required(),
                TextInput::make('name')
                    ->label(__('app.resources.product.fields.name'))
                    ->required(),
                TextInput::make('slug')
                    ->label(__('app.resources.product.fields.slug'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('app.resources.product.fields.description'))
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label(__('app.resources.product.fields.category'))
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('unit_id')
                    ->label(__('app.resources.product.fields.unit'))
                    ->relationship('unit', 'name')
                    ->required(),
                TextInput::make('stock_quantity')
                    ->label(__('app.resources.product.fields.stock_quantity'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('minimum_stock')
                    ->label(__('app.resources.product.fields.minimum_stock'))
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('purchase_price')
                    ->label(__('app.resources.product.fields.purchase_price'))
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                TextInput::make('selling_price')
                    ->label(__('app.resources.product.fields.selling_price'))
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),
                TextInput::make('wholesale_price')
                    ->label(__('app.resources.product.fields.wholesale_price'))
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('wholesale_min_qty')
                    ->label(__('app.resources.product.fields.wholesale_min_qty'))
                    ->numeric(),
                TextInput::make('barcode')
                    ->label(__('app.resources.product.fields.barcode')),
                TextInput::make('brand')
                    ->label(__('app.resources.product.fields.brand')),
                TextInput::make('location')
                    ->label(__('app.resources.product.fields.location')),
                DatePicker::make('expiry_date')
                    ->label(__('app.resources.product.fields.expiry_date')),
                TextInput::make('batch_number')
                    ->label(__('app.resources.product.fields.batch_number')),
                Toggle::make('is_active')
                    ->label(__('app.resources.product.fields.is_active'))
                    ->required(),
                Toggle::make('track_stock')
                    ->label(__('app.resources.product.fields.track_stock'))
                    ->required(),
                Toggle::make('has_expiry')
                    ->label(__('app.resources.product.fields.has_expiry'))
                    ->required(),
                TextInput::make('images')
                    ->label(__('app.resources.product.fields.images')),
                Textarea::make('usage_instructions')
                    ->label(__('app.resources.product.fields.usage_instructions'))
                    ->columnSpanFull(),
            ]);
    }
}
