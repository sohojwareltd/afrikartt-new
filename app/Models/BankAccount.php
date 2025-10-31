<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_holder',
        'account_number',
        'routing_number',
        'account_type',
        'currency',
        'bank_address',
        'swift_code',
        'iban',
        'is_default',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Account type options
     */
    public static function getAccountTypes(): array
    {
        return [
            'Checking' => 'Checking',
            'Savings' => 'Savings',
        ];
    }

    /**
     * Status options
     */
    public static function getStatusOptions(): array
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'closed' => 'Closed',
        ];
    }

    /**
     * Currency options
     */
    public static function getCurrencyOptions(): array
    {
        return [
            'USD' => 'US Dollar (USD)',
            'EUR' => 'Euro (EUR)',
            'GBP' => 'British Pound (GBP)',
            'CAD' => 'Canadian Dollar (CAD)',
            'AUD' => 'Australian Dollar (AUD)',
            'JPY' => 'Japanese Yen (JPY)',
            'BDT' => 'Bangladeshi Taka (BDT)',
        ];
    }

    /**
     * Get the user that owns the bank account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active accounts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for default accounts
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get masked account number for security
     */
    public function getMaskedAccountNumberAttribute(): string
    {
        $accountNumber = $this->account_number;
        if (strlen($accountNumber) <= 4) {
            return $accountNumber;
        }
        
        return '****' . substr($accountNumber, -4);
    }

    /**
     * Get full account display name
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->bank_name . ' - ' . $this->getMaskedAccountNumberAttribute();
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Ensure only one default account per user
        static::saving(function ($bankAccount) {
            if ($bankAccount->is_default) {
                static::where('user_id', $bankAccount->user_id)
                    ->where('id', '!=', $bankAccount->id)
                    ->update(['is_default' => false]);
            }
        });
    }
}
