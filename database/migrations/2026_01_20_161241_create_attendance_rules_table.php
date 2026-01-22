<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_rules', function (Blueprint $table) {
            $table->id();
            $table->time('check_in_time')->default('09:00:00');
            $table->time('check_out_time')->default('17:00:00');
            $table->integer('late_threshold')->default(15); // minutes
            $table->integer('location_radius')->default(100); // meters
            $table->json('allowed_locations')->nullable();
            $table->boolean('is_active')->default(1)->comment('0: Inactive, 1: Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_rules');
    }
}
