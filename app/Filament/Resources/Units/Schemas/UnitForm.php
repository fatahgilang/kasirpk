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
                    ->required(),
                TextInput::make('symbol')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_base_unit')
                    ->required(),
                TextInput::make('conversion_factor')
                    ->required()
                    ->numeric()
                    ->default(1.0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
