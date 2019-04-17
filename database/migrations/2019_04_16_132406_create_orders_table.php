<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('passport_id');
            $table->string('checkout_id')->unique();
            $table->decimal('subtotal', 8, 2);
            $table->decimal('vat', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
