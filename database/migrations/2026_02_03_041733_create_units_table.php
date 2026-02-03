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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // kg, gram, karung, botol, tablet, dll
            $table->string('symbol'); // kg, g, krg, btl, tab
            $table->text('description')->nullable();
            $table->boolean('is_base_unit')->default(false); // unit dasar untuk konversi
            $table->decimal('conversion_factor', 10, 4)->default(1); // faktor konversi ke unit dasar
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
