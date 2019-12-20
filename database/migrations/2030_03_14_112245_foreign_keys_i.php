<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeysI extends Migration
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
        | TABLE: BEHAVIOR_STANDARD_ITEMS
        |--------------------------------------------------------------------------
        */
        Schema::table('behavior_standard_items', function (Blueprint $table) {
            $table->foreign('behavior_standard_id')
                ->references('id')->on('behavior_standards');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: BEHAVIOR_ASSESSMENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('behavior_assessments', function (Blueprint $table) {
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('behavior_standard_item_id')
                ->references('id')->on('behavior_standard_items');
            $table->foreign('behavior_standard_id')
                ->references('id')->on('behavior_standards');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: BEHAVIOR_ASSESSMENT_AVERAGES
        |--------------------------------------------------------------------------
        */
        Schema::table('behavior_assessment_averages', function (Blueprint $table) {
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('class_id')
                ->references('id')->on('classes');
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
