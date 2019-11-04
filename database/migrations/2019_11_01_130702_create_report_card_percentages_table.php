<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCardPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_card_percentages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();

            $table->unsignedBigInteger('quarter_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('grade_behavior_quarter_id')->nullable();
            $table->text('days_absent')->nullable();
            $table->text('days_present')->nullable();
            $table->text('days_tardy')->nullable();
            $table->text('comment')->nullable();

            $table->integer('user_created_id')->nullable();
            $table->string('user_created_ip')->nullable();
            $table->string('user_updated_ip')->nullable();
            $table->integer('user_updated_id')->nullable();
            $table->boolean('is_protected')->nullable()->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_card_percentages');
    }
}
