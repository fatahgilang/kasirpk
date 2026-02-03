<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            // Detail Item
            $table->string('product_name'); // snapshot nama produk saat transaksi
            $table->string('product_code'); // snapshot kode produk
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 2); // harga per unit saat transaksi
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2); // quantity * unit_price - discount
            
            // Informasi Tambahan
            $table->text('notes')->nullable(); // catatan khusus (dosis, instruksi)
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
