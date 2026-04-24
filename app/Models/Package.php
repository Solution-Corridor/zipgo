<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'investment_amount',
        'daily_profit_min',
        'daily_profit_max',
        'duration_days',
        'referral_bonus_level1',
        'referral_bonus_level2',
        'daily_tasks',
        'daily_task_price',
        'free_spins',
        'free_spin_price',
        'weekend_reward',
        'is_active',
        'plan_type', //silver, gold, diamond
        'is_daily_rewards',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'is_daily_rewards' => 'boolean',
        'investment_amount'    => 'decimal:2',
        'daily_profit_min'     => 'decimal:2',
        'daily_profit_max'     => 'decimal:2',
        'referral_bonus_level1'=> 'decimal:2',
        'referral_bonus_level2'=> 'decimal:2',
    ];

    // Optional: accessor for display
    public function getDailyProfitRangeAttribute(): string
    {
        return '$' . number_format($this->daily_profit_min, 2) .
               ' — $' . number_format($this->daily_profit_max, 2);
    }
}