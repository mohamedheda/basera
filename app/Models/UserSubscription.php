<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_package_id',
        'start_date',
        'end_date',
        'amount_paid',
        'status',
        'payment_method',
        'transaction_id',
        'payment_platform',
        'google_product_id',
        'google_purchase_token',
        'google_order_id',
        'google_purchase_state',
        'google_acknowledged',
        'apple_product_id',
        'apple_transaction_id',
        'apple_original_transaction_id',
        'apple_receipt',
        'apple_purchase_state',
        'receipt_data',
        'auto_renew',
        'last_verified_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'amount_paid' => 'decimal:2',
            'google_acknowledged' => 'boolean',
            'receipt_data' => 'array',
            'auto_renew' => 'boolean',
            'last_verified_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPackage()
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date >= now();
    }

    public function isExpired()
    {
        return $this->end_date < now();
    }
}
