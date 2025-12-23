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
        Schema::table('route_fares', function (Blueprint $table) {
            // Add unique constraint for vehicle_id, pickup_id, and dropoff_id combination
            $table->unique(['vehicle_id', 'pickup_id', 'dropoff_id'], 'unique_vehicle_pickup_dropoff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('route_fares', function (Blueprint $table) {
            $table->dropUnique('unique_vehicle_pickup_dropoff');
        });
    }
};
