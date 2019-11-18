<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();

            $table->text('to_model')->nullable();
            $table->unsignedBigInteger('to_id')->nullable();

            $table->text('from_model')->nullable();
            $table->unsignedBigInteger('from_id')->nullable();

            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('message_family_id')->nullable();

            $table->boolean('is_read')->nullable()->default(false);
            $table->dateTime('read_on')->nullable();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();

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
        Schema::dropIfExists('parent_messages');
    }
}
