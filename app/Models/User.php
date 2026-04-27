<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Complaint;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'pic',
        'phone',
        'whatsapp',
        'email',
        'username',
        'password',
        'type', // 0=> admin, 1=> user, 2=> expert
        'city_id',
        'status',
        'balance',
        'address',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'type' => 'integer',
        'status'      => 'integer',
        'city_id'     => 'integer',
        'balance'     => 'float',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];


    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id', 'id');
    }

    public function expertDetail()
    {
        return $this->hasOne(ExpertDetail::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
