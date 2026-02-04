<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int|null $category_id
 * @property int $unit_id
 * @property float $stock_quantity
 * @property float $minimum_stock
 * @property float $purchase_price
 * @property float $selling_price
 * @property float|null $wholesale_price
 * @property int|null $wholesale_min_qty
 * @property string|null $barcode
 * @property string|null $brand
 * @property string|null $location
 * @property \Carbon\Carbon|null $expiry_date
 * @property string|null $batch_number
 * @property bool $is_active
 * @property bool $track_stock
 * @property bool $has_expiry
 * @property array|null $images
 * @property string|null $usage_instructions
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product find($id, $columns = ['*'])
 */
class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'slug',
        'description',
        'category_id',
        'unit_id',
        'stock_quantity',
        'minimum_stock',
        'purchase_price',
        'selling_price',
        'wholesale_price',
        'wholesale_min_qty',
        'barcode',
        'brand',
        'location',
        'expiry_date',
        'batch_number',
        'is_active',
        'track_stock',
        'has_expiry',
        'images',
        'usage_instructions',
    ];

    protected $casts = [
        'stock_quantity' => 'decimal:4',
        'minimum_stock' => 'decimal:4',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'track_stock' => 'boolean',
        'has_expiry' => 'boolean',
        'images' => 'array',
        'expiry_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->code)) {
                $product->code = 'PRD-' . strtoupper(Str::random(6));
            }
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    // Convert stock quantity to human-readable format (e.g., 2 Karung, 5 Kg, 500 Gram)
    public function getFormattedStockAttribute(): string
    {
        if (!$this->track_stock) {
            return 'Tidak dilacak';
        }

        $baseUnit = $this->unit;
        if (!$baseUnit || !$baseUnit->is_base_unit) {
            return $this->stock_quantity . ' ' . ($baseUnit ? $baseUnit->symbol : 'unit');
        }

        // Get all units for this product, ordered by conversion factor (largest first)
        $productUnits = $this->productUnits()
            ->with('unit')
            ->where('is_active', true)
            ->orderBy('conversion_factor', 'desc')
            ->get();

        if ($productUnits->isEmpty()) {
            return $this->stock_quantity . ' ' . $baseUnit->symbol;
        }

        $remainingStock = $this->stock_quantity;
        $result = [];

        foreach ($productUnits as $productUnit) {
            $unit = $productUnit->unit;
            if (!$unit || $productUnit->conversion_factor <= 0) continue;
            
            $unitQuantity = floor($remainingStock / $productUnit->conversion_factor);
            if ($unitQuantity > 0) {
                $result[] = $unitQuantity . ' ' . $unit->name;
                $remainingStock -= $unitQuantity * $productUnit->conversion_factor;
            }
        }

        // Add remaining base units
        if ($remainingStock > 0) {
            $result[] = $remainingStock . ' ' . $baseUnit->name;
        }

        return implode(', ', $result) ?: '0 ' . $baseUnit->name;
    }

    // Convert quantity from selected unit to base unit (grams)
    public function convertToBaseUnit(float $quantity, int $unitId): float
    {
        if ($unitId == $this->unit_id) {
            // Base unit
            return $quantity;
        }

        $productUnit = $this->productUnits()
            ->where('unit_id', $unitId)
            ->where('is_active', true)
            ->first();

        if ($productUnit) {
            return $productUnit->toBaseUnit($quantity);
        }

        return $quantity; // Fallback to base unit
    }

    // Convert quantity from base unit (grams) to selected unit
    public function convertFromBaseUnit(float $baseQuantity, int $unitId): float
    {
        if ($unitId == $this->unit_id) {
            return $baseQuantity;
        }

        $productUnit = $this->productUnits()
            ->where('unit_id', $unitId)
            ->where('is_active', true)
            ->first();

        if ($productUnit) {
            return $productUnit->fromBaseUnit($baseQuantity);
        }

        return $baseQuantity;
    }

    // Get adjusted price for selected unit
    public function getPriceForUnit(float $basePrice, int $unitId): float
    {
        if ($unitId == $this->unit_id) {
            return $basePrice;
        }

        $productUnit = $this->productUnits()
            ->where('unit_id', $unitId)
            ->where('is_active', true)
            ->first();

        if ($productUnit && $productUnit->conversion_factor > 0) {
            // Price per unit = base price * conversion factor + adjustment
            return $productUnit->getFinalPrice();
        }

        return $basePrice;
    }

    // Check if sufficient stock available for given quantity in specified unit
    public function hasSufficientStock(float $quantity, int $unitId): bool
    {
        if (!$this->track_stock) {
            return true;
        }

        $baseQuantity = $this->convertToBaseUnit($quantity, $unitId);
        return $this->stock_quantity >= $baseQuantity;
    }

    // Helper methods
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        if (!$this->has_expiry || !$this->expiry_date) {
            return false;
        }
        
        return $this->expiry_date->diffInDays(now()) <= $days;
    }
}
