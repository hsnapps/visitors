<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoursePassportManyToMany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('course_passport', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('passport_id')->references('id')->on('passports');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('course_passport', function (Blueprint $table) {
            $table->dropForeign(['course_id', 'passport_id']);
        });
        Schema::enableForeignKeyConstraints();
    }
}
