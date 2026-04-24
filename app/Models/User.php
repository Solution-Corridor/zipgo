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
        'is_fd',
        'is_sensitive',
        'is_tasks_allowed',
        'is_balance_sharing_allowed',
        'is_withdraw_allowed',
        'is_complaint_allowed',
        'withdraw_timer',
        'withdraw_without_package',
        'balance',
        'address',
        'referred_by',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status'      => 'integer',
        'is_fd'       => 'boolean',
        'is_sensitive' => 'boolean',
        'is_tasks_allowed' => 'boolean',
        'is_balance_sharing_allowed' => 'boolean',
        'is_withdraw_allowed' => 'boolean',
        'is_complaint_allowed' => 'boolean',
        'withdraw_timer' => 'boolean',
        'withdraw_without_package' => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    protected $dates = ['last_activity'];

    /**
     * Get the user who referred this user (the referrer)
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }


    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }


    public function kycVerification()
    {
        return $this->hasOne(KycVerification::class);
    }

    public function getKycStatusAttribute()
    {
        return $this->kycVerification?->status ?? 'not_submitted';
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function withdraws()
    {
        return $this->hasMany(Withdrawal::class, 'user_id', 'id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id', 'id');
    }

    
}
