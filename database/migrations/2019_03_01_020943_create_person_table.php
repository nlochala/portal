<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->text('title')->nullable();
            $table->text('family_name')->nullable();
            $table->text('given_name')->nullable();
            $table->text('preferred_name')->nullable();
            $table->text('name_in_chinese')->nullable();
            $table->text('gender')->nullable();
            $table->timestamp('dob')->nullable();
            $table->text('email_school')->nullable();
            $table->text('email_primary')->nullable();
            $table->text('email_secondary')->nullable();
            $table->unsignedBigInteger('image_file_id')->nullable();
            $table->text('website')->nullable();
            $table->unsignedBigInteger('language_primary_id')->nullable();
            $table->unsignedBigInteger('language_secondary_id')->nullable();
            $table->unsignedBigInteger('language_tertiary_id')->nullable();
            $table->unsignedBigInteger('country_of_birth_id')->nullable();
            $table->unsignedBigInteger('ethnicity_id')->nullable();
            $table->timestamps();
            $table->integer('user_created_id')->nullable();
            $table->string('user_created_ip')->nullable();
            $table->string('user_updated_ip')->nullable();
            $table->integer('user_updated_id')->nullable();
            $table->softDeletes();

       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
