<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                    // e.g. "Starter Plan", "VIP 90 Days"
            $table->decimal('investment_amount', 12, 2);    // 100.00, 500.00, etc.
            $table->decimal('daily_profit_min', 10, 2);     // e.g. 2.50
            $table->decimal('daily_profit_max', 10, 2);     // e.g. 3.75
            $table->integer('duration_days');               // 30, 60, 365
            $table->decimal('referral_bonus_level1', 5, 2)->default(0); // percentage e.g. 5.00 = 5%
            $table->decimal('referral_bonus_level2', 5, 2)->default(0); // percentage e.g. 5.00 = 5%
            $table->boolean('is_active')->default(true);            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};