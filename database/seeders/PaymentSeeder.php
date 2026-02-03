<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $transactions = Transaction::all();
        $purchases = Purchase::all();
        $customers = Customer::all();

        // Buat pembayaran untuk beberapa transaksi (kredit)
        foreach ($transactions->take(5) as $transaction) {
            if ($transaction->customer_id && rand(1, 10) > 7) { // 30% chance untuk kredit
                Payment::create([
                    'payment_number' => 'PAY-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                    'payable_type' => Transaction::class,
                    'payable_id' => $transaction->id,
                    'customer_id' => $transaction->customer_id,
                    'user_id' => $user->id,
                    'payment_date' => $transaction->created_at->addDays(rand(1, 30)),
                    'amount' => $transaction->total_amount,
                    'payment_method' => collect(['cash', 'transfer', 'check'])->random(),
                    'reference_number' => 'REF-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'notes' => 'Pembayaran lunas transaksi ' . $transaction->transaction_number,
                    'status' => 'completed',
                ]);
            }
        }

        // Buat pembayaran untuk pembelian
        foreach ($purchases->where('payment_status', '!=', 'unpaid')->take(8) as $purchase) {
            $paymentAmount = $purchase->payment_status === 'paid' 
                ? $purchase->total_amount 
                : $purchase->total_amount * 0.5;

            Payment::create([
                'payment_number' => 'PAY-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'payable_type' => Purchase::class,
                'payable_id' => $purchase->id,
                'supplier_id' => $purchase->supplier_id,
                'user_id' => $user->id,
                'payment_date' => $purchase->purchase_date->addDays(rand(1, $purchase->supplier->payment_term_days)),
                'amount' => $paymentAmount,
                'payment_method' => collect(['transfer', 'check', 'cash'])->random(),
                'reference_number' => 'REF-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'notes' => 'Pembayaran pembelian ' . $purchase->purchase_number,
                'status' => 'completed',
            ]);
        }

        // Buat beberapa pembayaran standalone (pembayaran hutang lama)
        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();
            $randomDate = Carbon::now()->subDays(rand(1, 15));
            
            Payment::create([
                'payment_number' => 'PAY-' . $randomDate->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'payment_date' => $randomDate,
                'amount' => rand(100000, 2000000),
                'payment_method' => collect(['cash', 'transfer'])->random(),
                'reference_number' => 'REF-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'notes' => 'Pembayaran hutang lama',
                'status' => 'completed',
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}