<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PassportWetlabManyToMany extends Migration
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
            $table->foreign('wetlab_id')->references('id')->on('wet_labs');
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
        Schema::table('passport_wetlab', function (Blueprint $table) {
            $table->dropForeign(['wetlab_id', 'passport_id']);
        });
        Schema::enableForeignKeyConstraints();
    }
}
