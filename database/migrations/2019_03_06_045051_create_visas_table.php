<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('passport_id')->nullable();
            $table->unsignedBigInteger('visa_type_id')->nullable();
            $table->unsignedBigInteger('image_file_id')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->text('number')->nullable();
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->unsignedBigInteger('visa_entry_id')->nullable();
            $table->integer('entry_duration')->nullable();
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
        Schema::dropIfExists('visas');
    }
}
