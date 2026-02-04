<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $payment_number
 * @property int $payable_id
 * @property string $payable_type
 * @property float $amount
 * @property string $payment_method
 * @property string $status
 * @property string|null $reference
 * @property string|null $notes
 * @property \Carbon\Carbon|null $paid_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Payment extends Model
{
    //
}
