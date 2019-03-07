<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('person_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('image_file_id')->nullable();
            $table->text('family_name')->nullable();
            $table->text('given_name')->nullable();
            $table->text('number')->nullable();
            $table->dateTime('issue_date')->nullabel();
            $table->dateTime('expiration_date')->nullabel();
            $table->integer('user_created_id')->nullable();
            $table->string('user_created_ip')->nullable();
            $table->string('user_updated_ip')->nullable();
            $table->integer('user_updated_id')->nullable();
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
        Schema::dropIfExists('passports');
    }
}
