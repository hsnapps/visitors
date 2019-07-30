<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
        });

        Schema::table('passports', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->after('admin_id');

            $table->dropForeign(['passprt_title_id']);
            $table->dropColumn('passprt_title_id');
        });

        Schema::table('category_course', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::table('category_wet_lab', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::dropIfExists('passport_titles');

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

        Schema::dropIfExists('categories');

        Schema::create('passport_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10);
        });

        Schema::table('passports', function (Blueprint $table) {
            $table->unsignedInteger('passprt_title_id')->after('admin_id');
            $table->dropColumn('title');
            
            $table->foreign('passprt_title_id')->references('id')->on('passport_titles');
        });

        Schema::table('category_course', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('category_id')->references('id')->on('passport_titles');
        });

        Schema::table('category_wet_lab', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('wet_lab_id')->references('id')->on('wet_labs');
            $table->foreign('category_id')->references('id')->on('passport_titles');
        });

        Schema::enableForeignKeyConstraints();
    }
}
