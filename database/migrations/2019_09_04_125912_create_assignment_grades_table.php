<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->unsignedBigInteger('assignment_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->integer('points_earned')->nullable();
            $table->boolean('is_excused')->nullable()->default(false);
            $table->dateTime('date_completed')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('assignment_grades');
    }
}
