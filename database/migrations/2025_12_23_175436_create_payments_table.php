<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); 
            $table->string('gateway')->default('paypal'); 
            $table->string('transaction_id')->nullable(); 
            $table->string('payment_type')->default('credit'); 
            $table->decimal('amount_total', 10, 2);  
            $table->decimal('amount_received', 10, 2)->default(0); 
            $table->enum('pay_status',['pending', 'partial', 'complete'])->default('pending'); 
            $table->string('currency')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
