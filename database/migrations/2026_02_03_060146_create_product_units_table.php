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
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            
            // Konversi Unit
            $table->decimal('conversion_factor', 10, 4); // faktor konversi dari unit dasar
            $table->decimal('selling_price', 15, 2); // harga jual untuk unit ini
            $table->decimal('wholesale_price', 15, 2)->nullable(); // harga grosir
            $table->integer('wholesale_min_qty')->nullable();
            
            // Contoh: 1 karung = 50 kg, maka conversion_factor = 50
            // Jika unit dasar produk adalah kg, dan ini adalah karung
            
            $table->boolean('is_default')->default(false); // unit default untuk penjualan
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            $table->unique(['product_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_units');
    }
};
