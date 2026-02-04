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
        Schema::table('product_units', function (Blueprint $table) {
            $table->decimal('price_adjustment', 15, 2)->default(0)->after('selling_price');
            $table->renameColumn('selling_price', 'base_selling_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_units', function (Blueprint $table) {
            $table->dropColumn('price_adjustment');
            $table->renameColumn('base_selling_price', 'selling_price');
        });
    }
};
