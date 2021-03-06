<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('passport_id');
            $table->string('item_type')->comment('Either courses or wetlabs');
            $table->unsignedInteger('item_id')->comment('The record id in the tables courses or wetlabs');
            $table->string('title');
            $table->date('starts_on');
            $table->decimal('price', 8, 2);
            $table->integer('days')->default(1);
            $table->date('expiration_date');
            $table->string('checkout_id')->nullable();
            $table->timestamps();

            $table->foreign('passport_id')->references('id')->on('passports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
