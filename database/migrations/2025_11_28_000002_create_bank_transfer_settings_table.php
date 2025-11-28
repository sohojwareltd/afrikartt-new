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
        Schema::create('bank_transfer_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(true);
            $table->string('bank_name')->default('Bank of America');
            $table->string('account_holder')->default('John Doe');
            $table->string('account_number')->default('123456789');
            $table->string('routing_number')->default('026009593');
            $table->string('account_type')->default('Checking');
            $table->text('instructions')->nullable();
            $table->boolean('require_receipt')->default(true);
            $table->integer('max_file_size')->default(5120); // in KB (5MB)
            $table->timestamps();
        });

        // Insert default settings
        DB::table('bank_transfer_settings')->insert([
            'enabled' => true,
            'bank_name' => 'Bank of America',
            'account_holder' => 'John Doe',
            'account_number' => '123456789',
            'routing_number' => '026009593',
            'account_type' => 'Checking',
            'instructions' => 'Send the payment to the bank details above. Once the transfer is completed, upload your payment receipt or screenshot. Your order will be verified within 12–24 hours. After verification, your order will be marked as Paid and processed immediately.',
            'require_receipt' => true,
            'max_file_size' => 5120,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transfer_settings');
    }
};
