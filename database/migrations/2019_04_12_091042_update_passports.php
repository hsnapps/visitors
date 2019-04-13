<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePassports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passports', function (Blueprint $table) {
            $table->string('password')->default(bcrypt('1234'));
            $table->rememberToken();
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
            $table->dropColumn(['password', 'remember_token']);
        });
    }
}
