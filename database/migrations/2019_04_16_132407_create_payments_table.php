<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('passport_id');
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount', 8, 2);
            $table->boolean('online')->default(1);
            $table->string('card_type', 10)->nullable();
            $table->string('card_holder', 25)->nullable();
            $table->string('card_expiration', 7)->nullable()->comment('mm / yy');
            $table->string('card_last_4', 4)->nullable();
            $table->string('currency', 3)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
