<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    // Table ka naam (agar aapne migration mein 'otps' rakha hai)
    protected $table = 'otps';

    // Kaunse columns fill karne ki permission hai
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];

    // expires_at ko date object banane ke liye
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}