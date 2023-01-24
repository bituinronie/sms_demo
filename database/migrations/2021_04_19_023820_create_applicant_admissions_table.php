<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id');
            $table->string('priority_number')->unique();
            $table->enum('applicant_status', ['PENDING', 'ACCEPTED', 'ASSIGNED', 'OFFICIAL', 'ARCHIVED', 'DENIED']);
            $table->string('remark')->nullable();
            $table->enum('student_type', ['NEW','TRANSFEREE', 'SECOND COURSER', 'OLD']);
            $table->enum('method_teaching', ['ONLINE', 'MODULAR', 'MODULAR AND ONLINE']);
            $table->enum('semester', ['FIRST SEMESTER', 'SECOND SEMESTER', 'SUMMER'])->nullable();
            $table->foreignId('branch_id');
            $table->string('learner_reference_number')->nullable();
            $table->string('education_level');
            $table->string('grade_year_level')->nullable();
            $table->foreignId('strand_id')->nullable();
            $table->foreignId('program_id')->nullable();
            $table->string('school_year');
            $table->enum('previous_school_type', ['PUBLIC SCHOOL', 'PRIVATE SCHOOL'])->nullable();
            $table->string('voucher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_admissions');
    }
}
