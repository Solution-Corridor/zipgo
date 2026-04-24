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
        'type',
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
        'status'      => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    protected $dates = ['last_activity'];

   
    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id', 'id');
    }

    
}
