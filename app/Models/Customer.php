<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $livestock_type
 * @property int|null $livestock_count
 * @property string $customer_type
 * @property float $credit_limit
 * @property float $current_debt
 * @property int $payment_term_days
 * @property int $loyalty_points
 * @property float $total_purchases
 * @property \Carbon\Carbon|null $last_purchase_date
 * @property bool $is_active
 * @property bool $allow_credit
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer find($id, $columns = ['*'])
 */
class Customer extends Model
{
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'livestock_type',
        'livestock_count',
        'customer_type',
        'credit_limit',
        'current_debt',
        'payment_term_days',
        'loyalty_points',
        'total_purchases',
        'last_purchase_date',
        'is_active',
        'allow_credit',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_debt' => 'decimal:2',
        'total_purchases' => 'decimal:2',
        'last_purchase_date' => 'date',
        'is_active' => 'boolean',
        'allow_credit' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($customer) {
            if (empty($customer->code)) {
                $customer->code = 'CUST-' . strtoupper(Str::random(6));
            }
        });
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Helper methods
    public function canPurchaseOnCredit(float $amount): bool
    {
        if (!$this->allow_credit) {
            return false;
        }
        
        return ($this->current_debt + $amount) <= $this->credit_limit;
    }

    public function getRemainingCreditAttribute(): float
    {
        return $this->credit_limit - $this->current_debt;
    }

    public function addLoyaltyPoints(int $points): void
    {
        $this->increment('loyalty_points', $points);
    }
}
