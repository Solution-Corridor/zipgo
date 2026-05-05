<?php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'slug', 'pic', 'price', 'detail', 'is_active', 'is_priority'];

  public function experts()
  {
    return $this->hasMany(ExpertDetail::class, 'service_id');
  }

  public function subServices()
  {
    return $this->hasMany(SubService::class);
  }
}
