<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoryCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_course', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('course_id');

            $table->foreign('course_id')->references('id')->on('courses');
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
        Schema::dropIfExists('category_course');
        Schema::enableForeignKeyConstraints();
    }
}
