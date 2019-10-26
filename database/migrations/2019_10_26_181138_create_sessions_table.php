<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('passport_wetlab', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->after('wetlab_id')->nullable();
            $table->foreign('session_id')->references('id')->on('sessions');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('wetlab_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->smallInteger('seats')->default(1);
            $table->timestamps();

            $table->foreign('wetlab_id')->references('id')->on('wet_labs');
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
        Schema::dropIfExists('sessions');
        Schema::table('passport_wetlab', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropColumn('session_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
