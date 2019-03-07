<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        |--------------------------------------------------------------------------
        | TABLE: PERSONS
        |--------------------------------------------------------------------------
        */
        Schema::table('persons', function (Blueprint $table) {
            $table->foreign('image_file_id')
                ->references('id')->on('files');
            $table->foreign('language_primary_id')
                ->references('id')->on('languages');
            $table->foreign('language_secondary_id')
                ->references('id')->on('languages');
            $table->foreign('language_tertiary_id')
                ->references('id')->on('languages');
            $table->foreign('country_of_birth_id')
                ->references('id')->on('countries');
            $table->foreign('ethnicity_id')
                ->references('id')->on('ethnicities');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: USERS
        |--------------------------------------------------------------------------
        */
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: PHONES
        |--------------------------------------------------------------------------
        */
        Schema::table('phones', function (Blueprint $table) {
            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('phone_type_id')
                ->references('id')->on('phone_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: PASSPORTS
        |--------------------------------------------------------------------------
        */
        Schema::table('passports', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->foreign('image_file_id')
                ->references('id')->on('files');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ID CARDS
        |--------------------------------------------------------------------------
        */
        Schema::table('id_cards', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('image_file_id')
                ->references('id')->on('files');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: VISAS
        |--------------------------------------------------------------------------
        */
        Schema::table('visas', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('image_file_id')
                ->references('id')->on('files');
            $table->foreign('visa_type_id')
                ->references('id')->on('visa_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ADDRESSES
        |--------------------------------------------------------------------------
        */
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->foreign('address_type_id')
                ->references('id')->on('address_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: FILES
        |--------------------------------------------------------------------------
        */
        Schema::table('files', function (Blueprint $table) {
            $table->foreign('file_extension_id')
                ->references('id')->on('file_extensions');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: FILE AUDITS
        |--------------------------------------------------------------------------
        */
        Schema::table('file_audits', function (Blueprint $table) {
            $table->foreign('file_id')
                ->references('id')->on('files');
            $table->foreign('person_id')
                ->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            //
        });
    }
}
