<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePassportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_passport', function (Blueprint $table) {
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('passport_id');
            $table->boolean('paid')->default(0);
            $table->boolean('cancelled_by_visitor')->default(0);
            $table->boolean('cancelled_by_provider')->default(0);
            $table->boolean('attended')->default(0);

            // $table->foreign('course_id')->references('id')->on('courses');
            // $table->foreign('passport_id')->references('id')->on('passports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_passport');
    }
}
