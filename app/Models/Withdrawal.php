<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'method',
        'amount',
        'account_number',
        'account_title',
        'bank_name',
        'status',
        'is_refund',
        'processed_at',
        'transaction_id',
        'remarks',
        'approved_at',
        'rejected_at',
        'cancelled_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
