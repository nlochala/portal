<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->string('username')->nullable();
            $table->text('email')->nullable();
            $table->text('display_name')->nullable();
            $table->text('given_name')->nullable();
            $table->text('family_name')->nullable();
            $table->string('azure_id')->nullable();
            $table->unsignedBigInteger('thumbnail_file_id')->default(2);
            $table->rememberToken();
            $table->timestamps();
            $table->integer('user_created_id')->nullable();
            $table->string('user_created_ip')->nullable();
            $table->string('user_updated_ip')->nullable();
            $table->integer('user_updated_id')->nullable();
            $table->boolean('is_protected')->nullable()->default(false);
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
        Schema::dropIfExists('users');
    }
}
