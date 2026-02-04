<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        // Only process completed transactions
        if ($transaction->status !== 'completed') {
            return;
        }

        // Process each transaction item
        $transaction->transactionItems->each(function (TransactionItem $item) {
            $product = $item->product;
            
            if ($product && $product->track_stock) {
                // Deduct stock quantity
                $product->decrement('stock_quantity', $item->quantity);
            }
        });
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
