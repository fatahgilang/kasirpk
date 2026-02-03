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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // kode pelanggan
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            // Informasi Peternak
            $table->string('livestock_type')->nullable(); // jenis ternak (ayam, sapi, kambing, dll)
            $table->integer('livestock_count')->nullable(); // jumlah ternak
            $table->enum('customer_type', ['retail', 'wholesale', 'reseller'])->default('retail');
            
            // Manajemen Kredit
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('current_debt', 15, 2)->default(0);
            $table->integer('payment_term_days')->default(0); // jangka waktu pembayaran (hari)
            
            // Program Loyalitas
            $table->integer('loyalty_points')->default(0);
            $table->decimal('total_purchases', 15, 2)->default(0);
            $table->date('last_purchase_date')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('allow_credit')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
