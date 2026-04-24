<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'trx_type',
        'detail',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
        // or more explicit:
        // return $this->belongsTo(User::class, 'user_id', 'id');
    }
}