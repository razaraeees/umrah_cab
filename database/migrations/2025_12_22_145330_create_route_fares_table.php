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
        Schema::create('route_fares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_id')->constrained('pick_up_locations')->onDelete('cascade');
            $table->foreignId('dropoff_id')->constrained('drop_locations')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_fares');
    }
};
