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
                    ->label('Nama Kategori')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                    )
                    ->columnSpan(1),
                
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->columnSpan(1),
                    
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('icon')
                    ->label('Icon')
                    ->placeholder('heroicon-o-tag')
                    ->helperText('Gunakan nama icon Heroicon')
                    ->columnSpan(1),
                
                ColorPicker::make('color')
                    ->label('Warna')
                    ->default('#6366f1')
                    ->columnSpan(1),
                
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
