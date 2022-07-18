<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'paid_data',
        'verify_data',
        'status',
        'payment_method'
    ];

    protected $casts = [
        'paid_data' => 'array',
        'verify_data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
}
