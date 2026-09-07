<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * booking_id is the PNR the public "check booking status" form looks up,
 * and BookingController validates it as unique.
 */
return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bookings')) {
            return;
        }

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->string('name');
            $table->date('travel_date');
            $table->string('travel_from');
            $table->string('travel_to');
            $table->string('booking_status');
            $table->string('payment_status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
