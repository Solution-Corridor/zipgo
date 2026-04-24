<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'payment_method_id',
        'transaction_id',
        'receipt_path',
        'amount',
        'status',
        'is_upgrade',
        'deducted_from_wallet',
        'notes',
        'approved_at',
        'rejected_at',
        'admin_note',
        'expires_at',
    ];

    // Payment.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'plan_id', 'id');
    }
}
