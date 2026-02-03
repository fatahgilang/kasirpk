<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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

    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
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
