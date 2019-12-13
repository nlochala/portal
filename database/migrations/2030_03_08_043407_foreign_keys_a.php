<?php /** @noinspection ALL */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysA extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
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
        Schema::table('roles_users_pivot', function (Blueprint $table) {
            $table->foreign('role_id')
                ->references('id')->on('roles');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: PERMISSIONS_ROLES_PIVOT
        |--------------------------------------------------------------------------
        */
        Schema::table('permissions_roles_pivot', function (Blueprint $table) {
            $table->foreign('permission_id')
                ->references('id')->on('permissions');
            $table->foreign('role_id')
                ->references('id')->on('roles');
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
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
        });

        /*
        |--------------------------------------------------------------------------
        | TABLE: ATTENDANCE_DAYS
        |--------------------------------------------------------------------------
        */
        Schema::table('attendance_days', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')->on('students');
            $table->foreign('attendance_type_id')
                ->references('id')->on('attendance_types');
            $table->foreign('quarter_id')
                ->references('id')->on('quarters');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}
