<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdGroupsUsersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_groups_users_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('ad_group_id')->nullable();
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
        Schema::dropIfExists('ad_groups_users_pivot');
    }
}
