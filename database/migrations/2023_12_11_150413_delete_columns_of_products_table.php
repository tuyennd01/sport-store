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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['stock', 'size']);
            // Only add 'original_price' if it doesn't exist
            if (!Schema::hasColumn('products', 'original_price')) {
                $table->string('original_price')->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Check if the column exists before trying to drop it
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }

            // Check if the column exists before trying to drop it
            if (Schema::hasColumn('products', 'size')) {
                $table->dropColumn('size');
            }

            // Check if the column exists before trying to drop it
            if (Schema::hasColumn('products', 'original_price')) {
                $table->dropColumn('original_price');
            }
        });
    }
};
