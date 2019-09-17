<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->unsignedBigInteger('assignment_type_id')->nullable();
            $table->unsignedBigInteger('quarter_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date_assigned')->nullable();
            $table->dateTime('date_due')->nullable();
            $table->integer('max_points')->nullable();
            $table->boolean('can_display')->nullable()->default(false);
            $table->boolean('is_test')->nullable()->default(false);
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
        Schema::dropIfExists('assignments');
    }
}
