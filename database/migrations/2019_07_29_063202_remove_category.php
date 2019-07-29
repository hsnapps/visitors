<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'category')) {
                $table->dropColumn('category');
            }
        });

        Schema::table('wet_labs', function (Blueprint $table) {
            if (Schema::hasColumn('wet_labs', 'category')) {
                $table->dropColumn('category');
            }
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
            $table->string('category')->nullable();
        });

        Schema::table('wet_labs', function (Blueprint $table) {
            $table->string('category')->nullable();
        });
    }
}
