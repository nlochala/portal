<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysC extends Migration
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
        | TABLE: ASSIGNMENT_TYPES
        |--------------------------------------------------------------------------
        */
        Schema::table('assignment_types', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ASSIGNMENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('assignment_type_id')
                ->references('id')->on('assignment_types');
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
            $table->foreign('class_id')
                ->references('id')->on('classes');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ASSIGNMENT_GRADES
        |--------------------------------------------------------------------------
        */
        Schema::table('assignment_grades', function (Blueprint $table) {
            $table->foreign('assignment_id')
                ->references('id')->on('assignments');
            $table->foreign('student_id')
                ->references('id')->on('students');
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
