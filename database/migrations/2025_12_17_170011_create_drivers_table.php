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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                   
            $table->string('phone')->nullable();      
            $table->string('email')->nullable();      
            $table->string('status')->default('active');  
            $table->unsignedBigInteger('car_id')->nullable();      
            $table->string('rc_copy')->nullable();
            $table->string('driving_license')->nullable();   
            $table->date('dl_expiry')->nullable();  
            $table->string('insurance_copy')->nullable(); 
            $table->string('car_image')->nullable();
            $table->string('driver_image')->nullable(); 
            $table->timestamps();
            $table->foreign('car_id')->references('id')->on('car_details')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
