<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysD extends Migration
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
        | TABLE: GRADE_AVERAGES
        |--------------------------------------------------------------------------
        */
        Schema::table('grade_averages', function (Blueprint $table) {
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('assignment_type_id')
                ->references('id')->on('assignment_types');
            $table->foreign('grade_scale_id')
                ->references('id')->on('grade_scales');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: GRADE_QUARTER_AVERAGES
        |--------------------------------------------------------------------------
        */
        Schema::table('grade_quarter_averages', function (Blueprint $table) {
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
