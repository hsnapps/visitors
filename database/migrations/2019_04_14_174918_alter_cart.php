<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('title')->after('item_id');
            $table->date('starts_on')->after('title');
            $table->decimal('price', 8, 2)->after('starts_on');
            $table->integer('days')->default(1)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'starts_on',
                'price',
                'days'
            ]);
        });
    }
}
