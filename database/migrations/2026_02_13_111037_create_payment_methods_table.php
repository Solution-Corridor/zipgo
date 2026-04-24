<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('account_type');          // easypaisa, jazzcash, nayapay, sadapay, bank
            $table->string('account_title');
            $table->string('account_number')->nullable();
            $table->string('iban')->nullable();
            $table->text('details')->nullable();     // branch name, bank name, additional instructions etc.
            $table->string('receipt_sample')->nullable(); // path to uploaded image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};