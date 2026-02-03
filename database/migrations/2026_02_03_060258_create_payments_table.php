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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique();
            $table->morphs('payable'); // bisa untuk transaction atau purchase
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Detail Pembayaran
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['cash', 'transfer', 'qris', 'check', 'other']);
            $table->date('payment_date');
            
            // Informasi Tambahan
            $table->string('reference_number')->nullable(); // no referensi bank/qris
            $table->text('notes')->nullable();
            $table->json('payment_details')->nullable(); // detail tambahan
            
            // Status
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('completed');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
