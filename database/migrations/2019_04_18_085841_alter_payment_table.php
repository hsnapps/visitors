<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_result_id', 64)->nullable()->after('currency');
            $table->string('payment_result_code', 11)->nullable()->after('payment_result_id');
            $table->string('payment_result_description', 64)->nullable()->after('payment_result_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_result_id',
                'payment_result_code',
                'payment_result_description',
            ]);
        });
    }
}
