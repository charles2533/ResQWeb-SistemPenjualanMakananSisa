<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'subtotal_price' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
