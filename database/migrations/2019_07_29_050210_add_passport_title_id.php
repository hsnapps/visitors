<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassportTitleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passports', function (Blueprint $table) {
            $table->unsignedInteger('passprt_title_id')->after('admin_id');
            $table->dropColumn('title');
            
            $table->foreign('passprt_title_id')->references('id')->on('passport_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passports', function (Blueprint $table) {
            $table->dropColumn('passprt_title_id');
            $table->string('title');
        });
    }
}
