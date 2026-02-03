<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
