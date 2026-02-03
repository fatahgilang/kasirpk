<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Customer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('transaction_number')
                    ->label('No. Transaksi')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan(1),
                    
                Select::make('customer_id')
                    ->label('Pelanggan')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Telepon'),
                        TextInput::make('email')
                            ->label('Email')
                            ->email(),
                    ])
                    ->columnSpan(1),
                    
                Select::make('user_id')
                    ->label('Kasir')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan(1),
                    
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Tunai',
                        'transfer' => 'Transfer',
                        'qris' => 'QRIS',
                        'credit' => 'Kredit'
                    ])
                    ->default('cash')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan(1),
                    
                TextInput::make('discount_amount')
                    ->label('Diskon')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0)
                    ->columnSpan(1),
                    
                TextInput::make('tax_amount')
                    ->label('Pajak')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0)
                    ->columnSpan(1),
                    
                TextInput::make('total_amount')
                    ->label('Total')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan(1),
                    
                TextInput::make('paid_amount')
                    ->label('Dibayar')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->columnSpan(1),
                    
                TextInput::make('change_amount')
                    ->label('Kembalian')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    ->columnSpan(1),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Lunas',
                        'partial' => 'Sebagian',
                        'unpaid' => 'Belum Bayar'
                    ])
                    ->default('paid')
                    ->required()
                    ->columnSpan(1),
                    
                Select::make('status')
                    ->label('Status Transaksi')
                    ->options([
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        'refunded' => 'Dikembalikan'
                    ])
                    ->default('completed')
                    ->required()
                    ->columnSpan(1),
                    
                DatePicker::make('due_date')
                    ->label('Jatuh Tempo')
                    ->visible(fn ($get) => $get('payment_method') === 'credit')
                    ->columnSpan(1),
                    
                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }
}
