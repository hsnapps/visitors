<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->default(0);
            $table->integer('admin_id')->default(0);
            $table->string('title');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('work_place');
            $table->string('country');
            $table->text('bar_code')->nullable();
            $table->string('code')->nullable();
            $table->string('amount')->nullable();
            $table->string('mobile_no');
            $table->string('profession');
            $table->string('specialist')->nullable();
            $table->string('sfch_number')->nullable();
            $table->string('sfch_image')->nullable();
            $table->string('bank_recipt')->nullable();
            $table->string('email')->unique();
            $table->string('expire_date')->nullable();
            $table->boolean('approved')->default(0);
            $table->boolean('payment')->default(0);
            $table->string('conference_reg')->nullable();
            $table->string('wet_lab_reg')->nullable();
            $table->string('type_of_payment')->nullable();
            $table->string('status')->nullable();
            $table->string('password')->default(bcrypt('1234'));
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passports');
    }
}
