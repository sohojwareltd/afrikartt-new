<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransferSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'enabled',
        'bank_name',
        'account_holder',
        'account_number',
        'routing_number',
        'account_type',
        'instructions',
        'require_receipt',
        'max_file_size',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'require_receipt' => 'boolean',
        'max_file_size' => 'integer',
    ];

    /**
     * Get the singleton instance
     */
    public static function settings()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'enabled' => true,
                'bank_name' => 'Bank of America',
                'account_holder' => 'John Doe',
                'account_number' => '123456789',
                'routing_number' => '026009593',
                'account_type' => 'Checking',
                'instructions' => 'Send the payment to the bank details above. Once the transfer is completed, upload your payment receipt or screenshot. Your order will be verified within 12–24 hours. After verification, your order will be marked as Paid and processed immediately.',
                'require_receipt' => true,
                'max_file_size' => 5120,
            ]
        );
    }
}
