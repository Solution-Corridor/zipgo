<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'win',
        'prize',
    ];

    protected $casts = [
        'win' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}