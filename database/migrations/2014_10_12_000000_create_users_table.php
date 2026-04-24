<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            // id int(10) NOT NULL AUTO_INCREMENT
            $table->integer('id', false, true)->autoIncrement();

            $table->string('name', 100)->nullable();
            $table->string('pic', 100)->nullable();
            $table->string('phone', 100);
            $table->string('username', 100);            
            $table->string('email', 100)->nullable();
            $table->string('password', 100);
            $table->integer('referred_by')->nullable();

            $table->string('type', 100)
                  ->comment('0=admin, 1=user');

            $table->integer('status')
                  ->default(1);

            $table->dateTime('created_at')
                  ->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->dateTime('updated_at')
                  ->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
