<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $shift_type
 * @property \Carbon\Carbon $started_at
 * @property \Carbon\Carbon|null $ended_at
 * @property float $opening_balance
 * @property float $closing_balance
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class CashierShift extends Model
{
    //
}
