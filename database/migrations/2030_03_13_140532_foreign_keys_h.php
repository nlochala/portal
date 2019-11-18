<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeysH extends Migration
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
        | TABLE: PARENT_MESSAGES
        |--------------------------------------------------------------------------
        */
        Schema::table('parent_messages', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('message_family_id')
                ->references('id')->on('parent_messages');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: CLASS_NEWSFEEDS
        |--------------------------------------------------------------------------
        */
        Schema::table('class_newsfeeds', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('author_employee_id')
                ->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
