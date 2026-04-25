<?php
// app/Models/ExpertDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertDetail extends Model
{
    use HasFactory;

    protected $table = 'expert_details';

    protected $fillable = [
        'user_id',
        'service_id',
        'nic_number',
        'nic_expiry',
        'nic_front_image',
        'nic_back_image',
        'selfie_image',
        'payment_status',
        'profile_status',
    ];

    protected $casts = [
        'nic_expiry'    => 'date',
        'profile_status'=> 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}