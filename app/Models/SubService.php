<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
  use HasFactory;

  protected $fillable = [
    'service_id',
    'name',
    'slug',
    'description',
    'price',
    'image',
    'is_active',
    'is_priority'
  ];

  public function service()
  {
    return $this->belongsTo(Service::class);
  }
}
