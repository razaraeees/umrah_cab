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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('guest_name');
            $table->string('guest_phone');
            $table->string('guest_whatsapp');
            $table->foreignId('pickup_location_id')->nullable()->constrained('pick_up_locations')->onDelete('set null');
            $table->string('pickup_location_name');
            $table->string('pickup_hotel_name')->nullable();
            // Dropoff Location Information
            $table->foreignId('dropoff_location_id')->nullable()->constrained('drop_locations')->onDelete('set null');
            $table->string('dropoff_location_name');
            $table->string('dropoff_hotel_name')->nullable();
            // Vehicle Information
            $table->foreignId('vehicle_id')->nullable()->constrained('car_details')->onDelete('set null');
            $table->string('vehicle_name');     
             // Passenger Information
            $table->integer('no_of_children')->default(0);
            $table->integer('no_of_infants')->default(0);
            $table->integer('no_of_adults')->default(1);
            $table->integer('total_passengers');
            $table->date('pickup_date');
            $table->time('pickup_time');
            
            $table->string('airline_name')->nullable(); // Backup name
            $table->string('flight_number')->nullable();
            $table->string('flight_details')->nullable();
            $table->date('arrival_departure_date')->nullable();
            $table->time('arrival_departure_time')->nullable();

            $table->text('extra_information')->nullable();
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            // Pricing (optional)
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('recived_paymnet', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
