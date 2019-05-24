<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->text('short_name')->nullable();
            $table->text('credits')->nullable();
            $table->integer('max_class_size')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->boolean('has_attendance')->nullable()->default(false);
            $table->boolean('show_on_report_card')->nullable()->default(false);
            $table->boolean('calculate_report_card')->nullable()->default(false);
            $table->boolean('calculate_on_transcript')->nullable()->default(false);
            $table->unsignedBigInteger('course_transcript_type_id')->nullable();
            $table->unsignedBigInteger('course_type_id')->nullable();
            $table->unsignedBigInteger('grade_scale_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
