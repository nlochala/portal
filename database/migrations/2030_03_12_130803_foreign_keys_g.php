<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeysG extends Migration
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
        | TABLE: REPORT_CARD_PERCENTAGES
        |--------------------------------------------------------------------------
        */
        Schema::table('report_card_percentages', function (Blueprint $table) {
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('grade_behavior_quarter_id')
                ->references('id')->on('grade_behavior_quarters');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: REPORT_CARD_PERCENTAGE_CLASSES
        |--------------------------------------------------------------------------
        */
        Schema::table('report_card_percentage_classes', function (Blueprint $table) {
            $table->foreign('report_card_percentage_id')
                ->references('id')->on('report_card_percentages');
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
    }
}
