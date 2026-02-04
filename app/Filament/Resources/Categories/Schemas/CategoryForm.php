<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('app.resources.category.fields.name'))
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                    )
                    ->columnSpan(1),
                
                TextInput::make('slug')
                    ->label(__('app.resources.category.fields.slug'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->columnSpan(1),
                    
                Textarea::make('description')
                    ->label(__('app.resources.category.fields.description'))
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('icon')
                    ->label(__('app.resources.category.fields.icon'))
                    ->placeholder('heroicon-o-tag')
                    ->helperText(__('app.resources.category.helpers.icon'))
                    ->columnSpan(1),
                
                ColorPicker::make('color')
                    ->label(__('app.resources.category.fields.color'))
                    ->default('#6366f1')
                    ->columnSpan(1),
                
                Toggle::make('is_active')
                    ->label(__('app.resources.category.fields.is_active'))
                    ->default(true)
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
