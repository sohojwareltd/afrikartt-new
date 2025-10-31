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
        Schema::create('shipping_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('hs_code')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('includes_battery')->default(false);
            $table->boolean('contains_battery_pi966')->default(false);
            $table->boolean('contains_battery_pi967')->default(false);
            $table->boolean('contains_liquids')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_categories');
    }
};
