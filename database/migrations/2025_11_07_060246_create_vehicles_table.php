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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');                    // e.g., Toyota Camry
            $table->integer('seats');                  // 4, 7, 10, etc.
            $table->integer('bags_capacity');                   // luggage capacity
            $table->text('features')->nullable();      // WiFi, AC, Child Seat, etc.
            $table->string('vehicle_image')->nullable();       // stored path: storage/app/public/vehicles/...
            $table->boolean('is_active')->default(1)->comment('0: Inactive, 1: Active');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
