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
        Schema::create('car_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model_variant')->nullable();            
            $table->string('color')->nullable();
            $table->string('door')->nullable();
            
            $table->string('bag_capacity')->nullable(); 
            $table->string('registration_number')->unique(); 
            $table->year('year')->nullable();
            $table->integer('seating_capacity')->nullable();
            $table->string('fuel_type')->nullable();         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_details');
    }
};
