<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $customers = Customer::all();
        $products = Product::all();

        // Buat 20 transaksi dummy untuk 7 hari terakhir
        for ($i = 0; $i < 20; $i++) {
            $customer = $customers->random();
            $randomDate = Carbon::now()->subDays(rand(0, 6));
            
            $transaction = Transaction::create([
                'transaction_number' => 'TRX-' . $randomDate->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'customer_id' => rand(1, 10) > 3 ? $customer->id : null, // 70% ada customer
                'user_id' => $user->id,
                'subtotal' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'total_amount' => 0,
                'paid_amount' => 0,
                'change_amount' => 0,
                'payment_method' => collect(['cash', 'transfer', 'qris'])->random(),
                'payment_status' => 'paid',
                'status' => 'completed',
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            // Tambahkan 1-5 item per transaksi
            $itemCount = rand(1, 5);
            $subtotal = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 10);
                $unitPrice = $product->selling_price;
                $itemSubtotal = $quantity * $unitPrice;
                $subtotal += $itemSubtotal;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_amount' => 0,
                    'subtotal' => $itemSubtotal,
                    'batch_number' => $product->batch_number,
                    'expiry_date' => $product->expiry_date,
                ]);
            }

            // Update total transaksi
            $transaction->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
                'paid_amount' => $subtotal,
            ]);
        }
    }
}
