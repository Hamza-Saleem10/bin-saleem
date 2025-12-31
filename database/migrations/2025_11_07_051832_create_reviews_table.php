<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('author');
            $table->string('location');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('booking_reference')->nullable();
            $table->string('route_detail')->nullable();
            $table->date('travel_date')->nullable();
            $table->text('comment');
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
        Schema::dropIfExists('reviews');
    }
};
