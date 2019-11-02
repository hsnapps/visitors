<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetStartsOnDatetime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dateTime('starts_on')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->date('starts_on')->change();
        });
    }
}
