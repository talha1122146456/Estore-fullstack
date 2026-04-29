<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Add this protected array
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'city',
        'address',
        'total_amount',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}