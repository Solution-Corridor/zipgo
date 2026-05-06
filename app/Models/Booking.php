<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
  use HasFactory;

  protected $table = 'bookings';

  // Specify which fields can be mass-assigned
  protected $fillable = [
    'user_id',
    'service_id',
    'expert_id',
    'assigned_at',
    'sub_service_id',
    'pickup_lat',
    'pickup_lng',
    'drop_lat',
    'drop_lng',
    'distance_km',
    'base_price',
    'per_km_rate',
    'distance_charge',
    'service_fee',
    'total_price',
    'status',
  ];

  // Cast attributes to appropriate types
  protected $casts = [
    'pickup_lat' => 'decimal:7',
    'pickup_lng' => 'decimal:7',
    'drop_lat' => 'decimal:7',
    'drop_lng' => 'decimal:7',
    'distance_km' => 'decimal:2',
    'base_price' => 'integer',
    'per_km_rate' => 'integer',
    'distance_charge' => 'integer',
    'service_fee' => 'integer',
    'total_price' => 'integer',
    'assigned_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  // Relationships
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function service()
  {
    return $this->belongsTo(Service::class);
  }

  public function subService()
  {
    return $this->belongsTo(SubService::class);
  }

  public function getFormattedTotalAttribute()
  {
    return 'Rs. ' . number_format($this->total_price, 0);
  }

  public function scopeForUser($query, $userId)
  {
    return $query->where('user_id', $userId);
  }

  public function expert()
  {
    return $this->belongsTo(User::class, 'expert_id');
  }
}
