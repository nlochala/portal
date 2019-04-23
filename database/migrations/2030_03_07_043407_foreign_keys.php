<?php /** @noinspection ALL */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        /*
        |--------------------------------------------------------------------------
        | TABLE: PERSONS
        |--------------------------------------------------------------------------
        */
        Schema::table('persons', function (Blueprint $table) {
            $table->foreign('person_type_id')
                ->references('id')->on('person_types');
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
            $table->foreign('thumbnail_file_id')
                ->references('id')->on('files');
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
            $table->foreign('front_image_file_id')
                ->references('id')->on('files');
            $table->foreign('back_image_file_id')
                ->references('id')->on('files');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: VISAS
        |--------------------------------------------------------------------------
        */
        Schema::table('visas', function (Blueprint $table) {
            $table->foreign('passport_id')
                ->references('id')->on('passports');
            $table->foreign('image_file_id')
                ->references('id')->on('files');
            $table->foreign('visa_type_id')
                ->references('id')->on('visa_types');
            $table->foreign('visa_entry_id')
                ->references('id')->on('visa_entries');
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
            $table->foreign('original_file_id')
                ->references('id')->on('files');
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

        /*
        |--------------------------------------------------------------------------
        | TABLE: EMPLOYEES
        |--------------------------------------------------------------------------
        */
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('employee_classification_id')
                ->references('id')->on('employee_classifications');
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('employee_status_id')
                ->references('id')->on('employee_statuses');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: OFFICIAL DOCUMENT TYPES
        |--------------------------------------------------------------------------
        */
        Schema::table('official_document_types', function (Blueprint $table) {
            $table->foreign('person_type_id')
                ->references('id')->on('person_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: OFFICIAL DOCUMENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('official_documents', function (Blueprint $table) {
            $table->foreign('official_document_type_id')
                ->references('id')->on('official_document_types');
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('file_id')
                ->references('id')->on('files');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: POSITIONS
        |--------------------------------------------------------------------------
        */
        Schema::table('positions', function (Blueprint $table) {
            $table->foreign('school_id')
                ->references('id')->on('schools');
            $table->foreign('position_type_id')
                ->references('id')->on('position_types');
            $table->foreign('supervisor_position_id')
                ->references('id')->on('positions');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: EMPLOYEE BONUSES
        |--------------------------------------------------------------------------
        */
        Schema::table('employee_bonuses', function (Blueprint $table) {
            $table->foreign('employee_bonus_type_id')
                ->references('id')->on('employee_bonus_types');
            $table->foreign('employee_id')
                ->references('id')->on('employees');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: EMPLOYEE / POSITION PIVOT
        |--------------------------------------------------------------------------
        */
        Schema::table('employees_positions_pivot', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')->on('employees');
            $table->foreign('position_id')
                ->references('id')->on('positions');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}
