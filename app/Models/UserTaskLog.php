<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTaskLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'payment_id',
        'task_id',
        'viewed_at',
        'started_at',
        'claimed_at',
        'assigned_price',
        'reward',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'viewed_at'   => 'datetime',
        'started_at'  => 'datetime',
        'claimed_at'  => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'assigned_price' => 'float',     // good to have
        'reward'         => 'float',     // if used
    ];

    // Remove the $dates array completely
}