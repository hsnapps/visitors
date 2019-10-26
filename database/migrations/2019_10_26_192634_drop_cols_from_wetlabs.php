<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColsFromWetlabs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wet_labs', function (Blueprint $table) {
            $table->dropColumn([
                'seats',
                'days',
                'price',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wet_labs', function (Blueprint $table) {
            $table->integer('seats')->default(50)->after('name');
            $table->integer('days')->default(1)->comment('Course duration in days')->after('seats');
            $table->decimal('price', 8, 2)->default(1000.00)->after('days');
        });
    }
}
