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

        /*
        |--------------------------------------------------------------------------
        | TABLE: ROOMS
        |--------------------------------------------------------------------------
        */
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('room_type_id')
                ->references('id')->on('room_types');
            $table->foreign('building_id')
                ->references('id')->on('buildings');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: GRADE_LEVELS
        |--------------------------------------------------------------------------
        */
        Schema::table('grade_levels', function (Blueprint $table) {
            $table->foreign('year_id')
                ->references('id')->on('years');
            $table->foreign('school_id')
                ->references('id')->on('schools');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: REPORT_CARD_WEIGHTS
        |--------------------------------------------------------------------------
        */
        Schema::table('report_card_weights', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: COURSES
        |--------------------------------------------------------------------------
        */
        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('course_transcript_type_id')
                ->references('id')->on('course_transcript_types');
            $table->foreign('grade_scale_id')
                ->references('id')->on('grade_scales');
            $table->foreign('department_id')
                ->references('id')->on('departments');
            $table->foreign('year_id')
                ->references('id')->on('years');
            $table->foreign('course_type_id')
                ->references('id')->on('course_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: COURSES_PREREQUISITES_PIVOT
        |--------------------------------------------------------------------------
        */
        Schema::table('courses_prerequisites_pivot', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses');
            $table->foreign('requires_course_id')
                ->references('id')->on('courses');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: COURSES_COREQUISITES_PIVOT
        |--------------------------------------------------------------------------
        */
        Schema::table('courses_corequisites_pivot', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses');
            $table->foreign('requires_course_id')
                ->references('id')->on('courses');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: COURSES_EQUIVALENTS_PIVOT
        |--------------------------------------------------------------------------
        */
        Schema::table('courses_equivalents_pivot', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses');
            $table->foreign('equivalent_to_course_id')
                ->references('id')->on('courses');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: COURSE_GRADE_LEVELS_PIVOT
        |--------------------------------------------------------------------------
        */
        Schema::table('courses_grade_levels_pivot', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses');
            $table->foreign('grade_level_id')
                ->references('id')->on('grade_levels');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: GRADE_SCALE_PERCENTAGES
        |--------------------------------------------------------------------------
        */
        Schema::table('grade_scale_percentages', function (Blueprint $table) {
            $table->foreign('grade_scale_id')
                ->references('id')->on('grade_scales');
            $table->foreign('equivalent_standard_id')
                ->references('id')->on('grade_scale_standards');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: GRADE_SCALE_STANDARDS
        |--------------------------------------------------------------------------
        */
        Schema::table('grade_scale_standards', function (Blueprint $table) {
            $table->foreign('grade_scale_id')
                ->references('id')->on('grade_scales');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: STUDENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('family_id')
                ->references('id')->on('families');
            $table->foreign('student_status_id')
                ->references('id')->on('student_statuses');
            $table->foreign('grade_level_id')
                ->references('id')->on('grade_levels');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: GUARDIAN
        |--------------------------------------------------------------------------
        */
        Schema::table('guardians', function (Blueprint $table) {
            $table->foreign('person_id')
                ->references('id')->on('persons');
            $table->foreign('family_id')
                ->references('id')->on('families');
            $table->foreign('guardian_type_id')
                ->references('id')->on('guardian_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: CLASSES
        |--------------------------------------------------------------------------
        */
        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses');
            $table->foreign('primary_employee_id')
                ->references('id')->on('employees');
            $table->foreign('secondary_employee_id')
                ->references('id')->on('employees');
            $table->foreign('ta_employee_id')
                ->references('id')->on('employees');
            $table->foreign('room_id')
                ->references('id')->on('rooms');
            $table->foreign('year_id')
                ->references('id')->on('years');
            $table->foreign('class_status_id')
                ->references('id')->on('class_statuses');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: QUARTERS
        |--------------------------------------------------------------------------
        */
        Schema::table('quarters', function (Blueprint $table) {
            $table->foreign('year_id')
                ->references('id')->on('years');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: Q1CLASSSTUDENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('q1_classes_students_pivot', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('student_id')
                ->references('id')->on('students');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: Q2CLASSSTUDENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('q2_classes_students_pivot', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('student_id')
                ->references('id')->on('students');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: Q3CLASSSTUDENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('q3_classes_students_pivot', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('student_id')
                ->references('id')->on('students');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: Q4CLASSSTUDENTS
        |--------------------------------------------------------------------------
        */
        Schema::table('q4_classes_students_pivot', function (Blueprint $table) {
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('student_id')
                ->references('id')->on('students');
        });

        /*
         |--------------------------------------------------------------------------
         | TABLE: ATTENDANCE_CLASSES
         |--------------------------------------------------------------------------
         */
        Schema::table('attendance_classes', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('class_id')
                ->references('id')->on('classes');
            $table->foreign('attendance_type_id')
                ->references('id')->on('attendance_types');
        });

        /*
         |--------------------------------------------------------------------------
         | TABLE: ATTENDANCE_DAY
         |--------------------------------------------------------------------------
         */
        Schema::table('attendance_days', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('attendance_type_id')
                ->references('id')->on('attendance_types');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ROLES
        |--------------------------------------------------------------------------
        */
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('ad_group_id')
                ->references('id')->on('ad_groups');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ROLES_USERS_PIVOT_TABLE
        |--------------------------------------------------------------------------
        */
        Schema::table('roles_users_pivot_table', function (Blueprint $table) {
            $table->foreign('role_id')
                ->references('id')->on('roles');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: PERMISSIONS_ROLES_PIVOT_TABLE
        |--------------------------------------------------------------------------
        */
        Schema::table('permissions_roles_pivot_table', function (Blueprint $table) {
            $table->foreign('permission_id')
                ->references('id')->on('permissions');
            $table->foreign('role_id')
                ->references('id')->on('roles');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}
