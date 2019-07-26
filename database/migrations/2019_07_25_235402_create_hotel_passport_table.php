<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPassportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_booking_passport', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_booking_id');
            $table->unsignedInteger('passport_id');
            $table->boolean('paid')->default(0);
            $table->boolean('cancelled_by_visitor')->default(0);
            $table->boolean('cancelled_by_provider')->default(0);
            $table->boolean('used')->default(0);
            $table->date('used_on')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('hotel_booking_id')->references('id')->on('hotel_bookings');
            $table->foreign('passport_id')->references('id')->on('passports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_booking_passport');
    }
}
