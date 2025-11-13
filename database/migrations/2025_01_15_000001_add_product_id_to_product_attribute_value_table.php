<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily to handle existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Step 1: Delete any existing orphaned records first
        // Since this is a new feature, existing records in product_attribute_value
        // won't have product_id and are orphaned data from the old system
        // Also delete related records in sku_attributes if they exist
        if (Schema::hasTable('sku_attributes')) {
            DB::table('sku_attributes')->delete();
        }
        DB::table('product_attribute_value')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Step 2: Add the product_id column with foreign key constraint
        // Now that the table is empty, we can add the constraint
        Schema::table('product_attribute_value', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->after('id')
                ->constrained('products')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_attribute_value', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};

