<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'account_type',
        'account_title',
        'account_number',
        'iban',
        'details',
        'receipt_sample',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}