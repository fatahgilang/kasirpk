<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $suppliers = Supplier::all();
        $products = Product::all();

        // Buat 15 pembelian dummy untuk 30 hari terakhir
        for ($i = 0; $i < 15; $i++) {
            $supplier = $suppliers->random();
            $randomDate = Carbon::now()->subDays(rand(0, 30));
            
            $purchase = Purchase::create([
                'purchase_number' => 'PUR-' . $randomDate->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'supplier_id' => $supplier->id,
                'user_id' => $user->id,
                'purchase_date' => $randomDate,
                'due_date' => $randomDate->copy()->addDays($supplier->payment_term_days),
                'subtotal' => 0,
                'discount_amount' => rand(0, 500000),
                'tax_amount' => 0,
                'total_amount' => 0,
                'paid_amount' => 0,
                'status' => collect(['pending', 'received', 'completed'])->random(),
                'payment_status' => collect(['unpaid', 'partial', 'paid'])->random(),
                'notes' => 'Pembelian rutin bulan ' . $randomDate->format('F Y'),
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            // Tambahkan 2-6 item per pembelian
            $itemCount = rand(2, 6);
            $subtotal = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(10, 100);
                $unitPrice = $product->purchase_price;
                $itemSubtotal = $quantity * $unitPrice;
                $subtotal += $itemSubtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_amount' => 0,
                    'subtotal' => $itemSubtotal,
                    'batch_number' => 'BATCH-' . $randomDate->format('Ymd') . '-' . rand(100, 999),
                    'expiry_date' => $product->has_expiry ? $randomDate->copy()->addMonths(rand(6, 24)) : null,
                ]);
            }

            // Hitung pajak (11% PPN)
            $taxAmount = $subtotal * 0.11;
            $totalAmount = $subtotal - $purchase->discount_amount + $taxAmount;
            
            // Set paid amount berdasarkan payment status
            $paidAmount = match($purchase->payment_status) {
                'paid' => $totalAmount,
                'partial' => $totalAmount * 0.5,
                'unpaid' => 0,
            };

            // Update total pembelian
            $purchase->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
            ]);
        }
    }
}