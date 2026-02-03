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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // kode produk
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete(); // unit dasar
            
            // Stok dan Harga
            $table->decimal('stock_quantity', 15, 4)->default(0);
            $table->decimal('minimum_stock', 15, 4)->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0); // harga beli
            $table->decimal('selling_price', 15, 2)->default(0); // harga jual
            $table->decimal('wholesale_price', 15, 2)->nullable(); // harga grosir
            $table->integer('wholesale_min_qty')->nullable(); // minimal qty untuk harga grosir
            
            // Informasi Produk
            $table->string('barcode')->nullable();
            $table->string('brand')->nullable();
            $table->string('location')->nullable(); // lokasi rak/gudang
            $table->date('expiry_date')->nullable(); // tanggal kedaluwarsa
            $table->string('batch_number')->nullable(); // nomor batch
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('track_stock')->default(true);
            $table->boolean('has_expiry')->default(false);
            
            // Metadata
            $table->json('images')->nullable();
            $table->text('usage_instructions')->nullable(); // instruksi pemakaian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
