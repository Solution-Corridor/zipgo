<?php

// app/Models/MobApp.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobApp extends Model
{
    protected $fillable = [
        'version',
    ];

    protected $casts = [
        'version' => 'string',
    ];
}
