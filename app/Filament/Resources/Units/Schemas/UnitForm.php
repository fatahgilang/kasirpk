<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('app.resources.unit.fields.name'))
                    ->required(),
                TextInput::make('symbol')
                    ->label(__('app.resources.unit.fields.symbol'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('app.resources.unit.fields.description'))
                    ->columnSpanFull(),
                Toggle::make('is_base_unit')
                    ->label(__('app.resources.unit.fields.is_base_unit'))
                    ->required(),
                TextInput::make('conversion_factor')
                    ->label(__('app.resources.unit.fields.conversion_factor'))
                    ->required()
                    ->numeric()
                    ->default(1.0),
                Toggle::make('is_active')
                    ->label(__('app.resources.unit.fields.is_active'))
                    ->required(),
            ]);
    }
}
