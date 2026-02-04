<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property int $unit_id
 * @property float $conversion_factor
 * @property float $base_selling_price
 * @property float|null $wholesale_price
 * @property int|null $wholesale_min_qty
 * @property bool $is_default
 * @property bool $is_active
 * @property float $price_adjustment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductUnit find($id, $columns = ['*'])
 */
class ProductUnit extends Model
{
    protected $fillable = [
        'product_id',
        'unit_id',
        'conversion_factor',
        'base_selling_price',
        'wholesale_price',
        'wholesale_min_qty',
        'is_default',
        'is_active',
        'price_adjustment',
    ];

    protected $casts = [
        'conversion_factor' => 'decimal:4',
        'base_selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'wholesale_min_qty' => 'integer',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'price_adjustment' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    // Convert quantity from this unit to base unit (grams)
    public function toBaseUnit($quantity): float
    {
        return $quantity * $this->conversion_factor;
    }

    // Convert quantity from base unit (grams) to this unit
    public function fromBaseUnit($baseQuantity): float
    {
        return $baseQuantity / $this->conversion_factor;
    }

    // Get final price for this unit (base price + adjustment)
    public function getFinalPrice(): float
    {
        return $this->base_selling_price + $this->price_adjustment;
    }
}
