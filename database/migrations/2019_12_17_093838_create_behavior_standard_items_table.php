<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBehaviorStandardItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behavior_standard_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();

            $table->unsignedBigInteger('behavior_standard_id')->nullable();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('value')->nullable();

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
        Schema::dropIfExists('behavior_standard_items');
    }
}
