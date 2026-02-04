<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property string|null $description
 * @property bool $is_base_unit
 * @property float $conversion_factor
 * @property bool $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit find($id, $columns = ['*'])
 */
class Unit extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'description',
        'is_base_unit',
        'conversion_factor',
        'is_active',
    ];

    protected $casts = [
        'is_base_unit' => 'boolean',
        'is_active' => 'boolean',
        'conversion_factor' => 'decimal:4',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }
}
