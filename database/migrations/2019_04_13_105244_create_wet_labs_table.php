<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWetLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wet_labs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('seats')->default(50);
            $table->date('starts_on');
            $table->integer('days')->default(1)->comment('Course duration in days');
            $table->decimal('price')->default(1000.00);
            $table->softDeletes();
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
        Schema::dropIfExists('wet_labs');
    }
}
