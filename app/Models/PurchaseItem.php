<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property float $quantity
 * @property float $unit_price
 * @property float $subtotal
 * @property string|null $batch_number
 * @property \Carbon\Carbon|null $expiry_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class PurchaseItem extends Model
{
    //
}
