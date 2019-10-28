<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         |--------------------------------------------------------------------------
         | TABLE: DAYS
         |--------------------------------------------------------------------------
         */
        Schema::table('days', function (Blueprint $table) {
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
        });

        /*
         |--------------------------------------------------------------------------
         | TABLE: HOLIDAYS
         |--------------------------------------------------------------------------
         */
        Schema::table('holidays', function (Blueprint $table) {
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
