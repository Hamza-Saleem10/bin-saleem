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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('voucher_number', 10)->nullable()->unique();
            $table->string('customer_name',191);
            $table->string('customer_email', 191)->nullable();
            $table->string('customer_contact', 20)->nullable();
            $table->integer('adult_person')->default(0);
            $table->integer('child_person')->default(0);
            $table->integer('infant_person')->default(0);
            $table->integer('number_of_pax')->default(0);
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
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
        Schema::dropIfExists('bookings');
    }
};
