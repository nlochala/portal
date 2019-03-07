<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('file_id')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->dateTime('download_date')->nullabel();
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
        Schema::dropIfExists('file_audits');
    }
}
