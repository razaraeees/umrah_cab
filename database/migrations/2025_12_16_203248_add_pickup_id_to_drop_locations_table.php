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
        Schema::table('drop_locations', function (Blueprint $table) {
            $table->foreignId('pick_up_location_id')
          ->after('id')
          ->constrained('pick_up_locations')
          ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drop_locations', function (Blueprint $table) {
            $table->dropForeign(['pick_up_location_id']);
            $table->dropColumn('pick_up_location_id');
        });
    }
};
