<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoryWetLab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_wet_lab', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('wet_lab_id');

            $table->foreign('wet_lab_id')->references('id')->on('wet_labs');
            $table->foreign('category_id')->references('id')->on('passport_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('category_wet_lab');
        Schema::enableForeignKeyConstraints();
    }
}
