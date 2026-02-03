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
        Schema::create('cashier_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // kasir
            $table->string('shift_number')->unique();
            
            // Waktu Shift
            $table->datetime('start_time');
            $table->datetime('end_time')->nullable();
            
            // Modal Awal dan Akhir
            $table->decimal('opening_cash', 15, 2)->default(0);
            $table->decimal('closing_cash', 15, 2)->nullable();
            $table->decimal('expected_cash', 15, 2)->nullable(); // cash yang seharusnya ada
            $table->decimal('cash_difference', 15, 2)->nullable(); // selisih cash
            
            // Ringkasan Transaksi
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_sales', 15, 2)->default(0);
            $table->decimal('cash_sales', 15, 2)->default(0);
            $table->decimal('non_cash_sales', 15, 2)->default(0);
            
            // Status
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_shifts');
    }
};
