<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertRate extends Model
{
  use HasFactory;

  protected $fillable = [
    'expert_id',
    'service_name',
    'rate',
    'description',
    'image',
  ];

  public function expertDetail()
  {
    return $this->belongsTo(ExpertDetail::class, 'expert_id');
  }
}
