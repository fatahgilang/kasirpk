<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class Kasir extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $title = 'Kasir';
    
    protected static ?string $navigationLabel = 'Kasir';
    
    protected static ?int $navigationSort = 1;

    public ?int $selectedCustomer = null;
    public string $searchQuery = '';
    public array $cart = [];
    
    public float $subtotal = 0;
    public float $discount = 0;
    public float $total = 0;
    public float $paid = 0;
    public float $change = 0;

    public function getView(): string
    {
        return 'filament.pages.kasir';
    }

    public function mount(): void
    {
        $this->calculateTotals();
    }

    #[Computed]
    public function availableProducts()
    {
        $query = Product::where('is_active', true)
            ->with(['category', 'unit']);
            
        if (!empty($this->searchQuery)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('code', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('brand', 'like', '%' . $this->searchQuery . '%');
            });
        }
        
        return $query->orderBy('name')->get();
    }

    #[Computed]
    public function availableCustomers()
    {
        return Customer::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function addToCart($productId): void
    {
        $product = Product::find($productId);
        
        if (!$product || !$product->is_active) {
            Notification::make()
                ->title('Produk tidak tersedia')
                ->danger()
                ->send();
            return;
        }

        // Check stock
        if ($product->track_stock && $product->stock_quantity <= 0) {
            Notification::make()
                ->title('Stok habis')
                ->body("Produk {$product->name} sudah habis")
                ->warning()
                ->send();
            return;
        }

        $existingIndex = collect($this->cart)->search(function ($item) use ($productId) {
            return $item['product_id'] == $productId;
        });

        if ($existingIndex !== false) {
            // Check stock limit
            if ($product->track_stock && ($this->cart[$existingIndex]['quantity'] + 1) > $product->stock_quantity) {
                Notification::make()
                    ->title('Stok tidak mencukupi')
                    ->body("Stok {$product->name} hanya tersisa {$product->stock_quantity}")
                    ->warning()
                    ->send();
                return;
            }
            
            $this->cart[$existingIndex]['quantity']++;
            $this->cart[$existingIndex]['subtotal'] = $this->cart[$existingIndex]['quantity'] * $this->cart[$existingIndex]['price'];
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'price' => $product->selling_price,
                'quantity' => 1,
                'subtotal' => $product->selling_price,
                'stock' => $product->stock_quantity,
            ];
        }

        $this->calculateTotals();
        
        Notification::make()
            ->title('Produk ditambahkan')
            ->body("{$product->name} berhasil ditambahkan")
            ->success()
            ->send();
    }

    public function removeFromCart($index): void
    {
        if (!isset($this->cart[$index])) return;

        $itemName = $this->cart[$index]['name'];
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        $this->calculateTotals();
        
        Notification::make()
            ->title('Item dihapus')
            ->body("{$itemName} telah dihapus dari keranjang")
            ->warning()
            ->send();
    }

    public function updateQuantity($index, $quantity): void
    {
        if (!isset($this->cart[$index])) return;

        if ($quantity <= 0) {
            $this->removeFromCart($index);
            return;
        }

        $item = $this->cart[$index];
        $product = Product::find($item['product_id']);
        
        // Check stock
        if ($product && $product->track_stock && $quantity > $product->stock_quantity) {
            Notification::make()
                ->title('Stok tidak mencukupi')
                ->body("Stok {$product->name} hanya tersisa {$product->stock_quantity}")
                ->warning()
                ->send();
            return;
        }

        $this->cart[$index]['quantity'] = $quantity;
        $this->cart[$index]['subtotal'] = $quantity * $this->cart[$index]['price'];
        $this->calculateTotals();
    }

    public function calculateTotals(): void
    {
        $this->subtotal = collect($this->cart)->sum('subtotal');
        $this->discount = max(0, min($this->discount, 100)); // Limit to 0-100%
        $discountAmount = $this->subtotal * ($this->discount / 100);
        $this->total = $this->subtotal - $discountAmount;
        $this->change = max(0, $this->paid - $this->total);
    }

    public function updatedDiscount(): void
    {
        $this->calculateTotals();
    }

    public function updatedPaid(): void
    {
        $this->calculateTotals();
    }

    public function processTransaction(): void
    {
        if (empty($this->cart)) {
            Notification::make()
                ->title('Keranjang kosong')
                ->body('Tambahkan produk ke keranjang terlebih dahulu')
                ->warning()
                ->send();
            return;
        }

        if ($this->paid < $this->total) {
            Notification::make()
                ->title('Pembayaran kurang')
                ->body('Jumlah pembayaran harus sama atau lebih dari total')
                ->warning()
                ->send();
            return;
        }

        try {
            DB::transaction(function () {
                $discountAmount = $this->subtotal * ($this->discount / 100);
                
                // Create transaction
                $transaction = Transaction::create([
                    'customer_id' => $this->selectedCustomer,
                    'user_id' => auth()->id(),
                    'subtotal' => $this->subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => 0,
                    'total_amount' => $this->total,
                    'paid_amount' => $this->paid,
                    'change_amount' => $this->change,
                    'payment_method' => 'cash',
                    'payment_status' => 'paid',
                    'status' => 'completed',
                ]);

                // Create transaction items and update stock
                foreach ($this->cart as $item) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'product_name' => $item['name'],
                        'product_code' => $item['code'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Update stock
                    $product = Product::find($item['product_id']);
                    if ($product && $product->track_stock) {
                        $product->decrement('stock_quantity', $item['quantity']);
                    }
                }

                // Clear cart
                $this->reset(['cart', 'selectedCustomer', 'subtotal', 'discount', 'total', 'paid', 'change']);

                Notification::make()
                    ->title('Transaksi berhasil!')
                    ->body("Transaksi {$transaction->transaction_number} telah disimpan")
                    ->success()
                    ->duration(5000)
                    ->send();
            });
        } catch (\Exception $e) {
            Notification::make()
                ->title('Transaksi gagal')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function clearCart(): void
    {
        $this->reset(['cart', 'subtotal', 'discount', 'total', 'paid', 'change']);
        
        Notification::make()
            ->title('Keranjang dikosongkan')
            ->body('Semua item telah dihapus')
            ->info()
            ->send();
    }

    public function setExactAmount(): void
    {
        $this->paid = $this->total;
        $this->calculateTotals();
    }

    public function setRoundedAmount(): void
    {
        $this->paid = ceil($this->total / 1000) * 1000;
        $this->calculateTotals();
    }
}