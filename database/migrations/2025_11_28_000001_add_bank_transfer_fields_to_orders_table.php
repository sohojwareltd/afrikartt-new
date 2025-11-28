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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bank_transfer_receipt')->nullable()->after('payment_method');
            $table->enum('bank_payment_status', ['pending', 'verified', 'rejected'])->default('pending')->after('bank_transfer_receipt');
            $table->text('bank_payment_notes')->nullable()->after('bank_payment_status');
            $table->timestamp('bank_payment_verified_at')->nullable()->after('bank_payment_notes');
            $table->unsignedBigInteger('bank_payment_verified_by')->nullable()->after('bank_payment_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'bank_transfer_receipt',
                'bank_payment_status',
                'bank_payment_notes',
                'bank_payment_verified_at',
                'bank_payment_verified_by'
            ]);
        });
    }
};
