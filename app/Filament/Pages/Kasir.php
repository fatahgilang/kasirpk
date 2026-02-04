<?php

namespace App\Filament\Pages;

/**
 * @method static \Illuminate\Contracts\Auth\StatefulGuard auth()
 * @method static int|null id()
 */

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

/**
 * POS Cashier Page
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\App\Models\Product> $availableProducts
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\App\Models\Customer> $availableCustomers
 * @method static \Illuminate\Contracts\Auth\Guard auth()
 */
class Kasir extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $title = 'Kasir';
    
    protected static ?string $navigationLabel = 'Kasir';
    
    protected static ?int $navigationSort = 1;

    /**
     * Selected customer ID
     *
     * @var int|null
     */
    public ?int $selectedCustomer = null;
    
    /**
     * Product search query
     *
     * @var string
     */
    public string $searchQuery = '';
    
    /**
     * Shopping cart items
     *
     * @var array<int, array{product_id: int, name: string, code: string, price: float, quantity: int, subtotal: float, stock: int, unit_id: int}>
     */
    public array $cart = [];
    
    /**
     * Track selected unit for each product in cart
     *
     * @var array<int, int>
     */
    public array $selectedUnits = [];
    
    /**
     * Subtotal amount
     *
     * @var float
     */
    public float $subtotal = 0;
    
    /**
     * Discount percentage
     *
     * @var float
     */
    public float $discount = 0;
    
    /**
     * Total amount
     *
     * @var float
     */
    public float $total = 0;
    
    /**
     * Amount paid
     *
     * @var float
     */
    public float $paid = 0;
    
    /**
     * Change amount
     *
     * @var float
     */
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
    public function availableProducts(): Collection
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
    public function availableCustomers(): Collection
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
            // Get default unit or base unit
            $defaultUnitId = $product->unit_id;
            $productUnits = $product->productUnits()->where('is_active', true)->get();
            
            if ($productUnits->isNotEmpty()) {
                $defaultUnit = $productUnits->firstWhere('is_default', true) ?? $productUnits->first();
                $defaultUnitId = $defaultUnit->unit_id;
            }
            
            $this->selectedUnits[$product->id] = $defaultUnitId;
            
            $this->cart[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'price' => $product->getPriceForUnit($product->selling_price, $defaultUnitId),
                'quantity' => 1,
                'subtotal' => $product->getPriceForUnit($product->selling_price, $defaultUnitId),
                'stock' => $product->stock_quantity,
                'unit_id' => $defaultUnitId,
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
                    'user_id' => \Illuminate\Support\Facades\Auth::id(),
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
                    $product = Product::find($item['product_id']);
                    
                    // Convert quantity to base unit (grams) for stock deduction
                    $baseQuantity = $product->convertToBaseUnit($item['quantity'], $item['unit_id'] ?? $product->unit_id);
                    
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'product_name' => $item['name'],
                        'product_code' => $item['code'],
                        'quantity' => $baseQuantity, // Store in base unit
                        'unit_price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Update stock in base unit (grams)
                    if ($product && $product->track_stock) {
                        $product->decrement('stock_quantity', $baseQuantity);
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

    public function updatedSelectedUnits($value, $propertyName): void
    {
        // Extract product ID from property name (e.g., "selectedUnits.1" -> 1)
        if (!str_starts_with($propertyName, 'selectedUnits.')) {
            return;
        }
        
        $productId = (int) str_replace('selectedUnits.', '', $propertyName);
        
        // Update price when unit is changed
        $cartIndex = collect($this->cart)->search(function ($item) use ($productId) {
            return $item['product_id'] == $productId;
        });

        if ($cartIndex !== false) {
            $product = Product::find($productId);
            if ($product) {
                $newPrice = $product->getPriceForUnit($product->selling_price, $value);
                $this->cart[$cartIndex]['price'] = $newPrice;
                $this->cart[$cartIndex]['subtotal'] = $this->cart[$cartIndex]['quantity'] * $newPrice;
                $this->cart[$cartIndex]['unit_id'] = $value;
                $this->calculateTotals();
            }
        }
    }

    public function getAvailableUnitsForProduct($productId): array
    {
        $product = Product::find($productId);
        if (!$product) return [];

        $units = [
            $product->unit_id => $product->unit->name
        ];

        $productUnits = $product->productUnits()
            ->with('unit')
            ->where('is_active', true)
            ->get();

        foreach ($productUnits as $productUnit) {
            $units[$productUnit->unit_id] = $productUnit->unit->name;
        }

        return $units;
    }
}