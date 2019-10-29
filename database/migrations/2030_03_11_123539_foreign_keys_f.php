<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysF extends Migration
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
        | TABLE: GRADE_BEHAVIOR_QUARTERS
        |--------------------------------------------------------------------------
        */
        Schema::table('grade_behavior_quarters', function (Blueprint $table) {
            $table->foreign('student_id')
                    ->references('id')->on('students');
            $table->foreign('grade_scale_id')
                    ->references('id')->on('grade_scales');
            $table->foreign('grade_scale_item_id')
                    ->references('id')->on('grade_scale_standards');
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
        Schema::dropIfExists('foreign_keys_f');
    }
}
