<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $purchase_number
 * @property int $supplier_id
 * @property int $user_id
 * @property float $subtotal
 * @property float $discount_amount
 * @property float $tax_amount
 * @property float $total_amount
 * @property string $status
 * @property string|null $notes
 * @property \Carbon\Carbon|null $received_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Purchase extends Model
{
    //
}
