<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EstablishForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /*****************************************  USER  *****************************************/
        Schema::table('user_accounts', function (Blueprint $table)
        {
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });




        /*****************************************  ADMISSION  *****************************************/

        Schema::table('applicant_admissions', function (Blueprint $table)
        {
            $table->foreign('applicant_id')->references('id')->on('applicant_personal_informations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('strand_id')->references('id')->on('strands');
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        Schema::table('applicant_education_backgrounds', function (Blueprint $table) {
            $table->foreign('applicant_id')->references('id')->on('applicant_personal_informations')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('applicant_requirements', function (Blueprint $table) {
            $table->foreign('applicant_id')->references('id')->on('applicant_personal_informations')->onDelete('cascade')->onUpdate('cascade');
        });




        /*****************************************  PROGRAMS  *****************************************/
        Schema::table('programs', function (Blueprint $table)
        {
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('branch_id')->references('id')->on('branches');
        });




        /*****************************************  STRANDS  *****************************************/
        Schema::table('strands', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
        });

        
        
        
        /*****************************************  STUDENT  *****************************************/
        
        Schema::table('student_accounts', function (Blueprint $table) {
            $table->foreign('applicant_id')->references('id')->on('applicant_personal_informations')->onDelete('cascade')->onUpdate('cascade');
        });




        /*****************************************  BUILDINGS  *****************************************/
        Schema::table('buildings', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
        });




        /*****************************************  DEPARTMENTS  *****************************************/
        Schema::table('departments', function (Blueprint $table)
        {
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('branch_id')->references('id')->on('branches');
        });




        /*****************************************  ACCOUNTING PROOF OF PAYMENT  *****************************************/
        Schema::table('accounting_proof_of_payments', function (Blueprint $table)
        {
            $table->foreign('applicant_id')->references('id')->on('applicant_personal_informations')->onDelete('cascade');
        });




        /*****************************************  EMPLOYEE  *****************************************/
        Schema::table('employees', function (Blueprint $table)
        {
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('branch_id')->references('id')->on('branches');
        });




        /*****************************************  ROOMS  *****************************************/
        Schema::table('rooms', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('laboratory_id')->references('id')->on('laboratories');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });

        


        /*****************************************  LABORATORIES  *****************************************/
        Schema::table('laboratories', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
        });




        /*****************************************  ACTIVITY LOGS  *****************************************/
        Schema::table('activity_logs', function (Blueprint $table)
        {
            $table->foreign('user_id')->references('id')->on('user_accounts')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('student_accounts')->onDelete('cascade');
        });




        /*****************************************  CURRICULUMS  *****************************************/
        Schema::table('curriculums', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('program_id')->references('id')->on('programs');
        });




        /*****************************************  CURRICULUM SUBJECTS *****************************************/
        Schema::table('curriculum_subjects', function (Blueprint $table)
        {
            $table->foreign('curriculum_id')->references('id')->on('curriculums');
            $table->foreign('prerequisite_subject_id')->references('id')->on('subjects');
            $table->foreign('corequisite_subject_id')->references('id')->on('subjects');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });




        /*****************************************  CURRICULUMS  *****************************************/
        Schema::table('sections', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('department_id')->references('id')->on('departments');
        });




        /*****************************************  SCHEDULE  *****************************************/
        Schema::table('schedules', function (Blueprint $table)
        {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('employee_id')->references('id')->on('employees');
        });




        /*****************************************  SCHEDULE DATES *****************************************/
        Schema::table('schedule_dates', function (Blueprint $table)
        {
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
