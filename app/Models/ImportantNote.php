<?php

// app/Models/ImportantNote.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantNote extends Model
{
    protected $fillable = [
        'message',
    ];

    protected $casts = [
        'message' => 'string',
    ];
}
