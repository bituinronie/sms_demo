<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantEducationBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_education_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id');
            $table->string('elementary_name')->nullable();
            $table->string('elementary_address')->nullable();
            $table->string('elementary_year_completed')->nullable();
            $table->string('junior_high_school_name')->nullable();
            $table->string('junior_high_school_address')->nullable();
            $table->string('junior_high_school_year_completed')->nullable();
            $table->string('senior_high_school_name')->nullable();
            $table->string('senior_high_school_strand')->nullable();
            $table->string('senior_high_school_address')->nullable();
            $table->string('senior_high_school_year_completed')->nullable();
            $table->string('college_name')->nullable();
            $table->string('college_course')->nullable();
            $table->string('college_address')->nullable();
            $table->string('college_year_completed')->nullable();
            $table->string('previous_school')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_education_backgrounds');
    }
}
