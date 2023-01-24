<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id');
            $table->string('profile_image');
            $table->string('spcf_cat_result')->nullable();
            $table->string('certificate_of_moral_character')->nullable();
            $table->string('nso_birth_certificate')->nullable();
            $table->string('form_137')->nullable();
            $table->string('police_clearance')->nullable();
            $table->string('barangay_clearance')->nullable();
            $table->string('transfer_credential')->nullable();
            $table->string('special_study_permit')->nullable();
            $table->string('alien_certificate_registration')->nullable();
            $table->string('passport')->nullable();
            $table->string('visa')->nullable();
            $table->string('medical_clearance')->nullable();
            $table->string('transcript_of_record')->nullable();
            $table->string('marriage_certificate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_requirements');
    }
}
