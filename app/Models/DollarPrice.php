<?php

// app/Models/DollarPrice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DollarPrice extends Model
{
    protected $fillable = [
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
