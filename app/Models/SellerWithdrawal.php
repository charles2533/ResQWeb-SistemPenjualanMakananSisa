<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerWithdrawal extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
