<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantPersonalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_personal_informations', function (Blueprint $table) {
            $table->id()->comment('Applicant ID');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->integer('age');
            $table->string('birth_date');
            $table->string('birth_place');
            $table->string('telephone_number')->nullable();
            $table->string('mobile_number');
            $table->string('email_address')->unique();
            $table->enum('civil_status', ['SINGLE', 'MARRIED', 'DIVORCED', 'SEPARATED', 'WIDOWED']);
            $table->string('nationality');
            $table->string('religion')->nullable();
            $table->string('current_address_house_number');
            $table->string('current_address_street_name');
            $table->string('current_address_barangay');
            $table->string('current_address_city');
            $table->string('current_address_province');
            $table->string('current_address_zip_code')->nullable();
            $table->string('permanent_address_house_number');
            $table->string('permanent_address_street_name');
            $table->string('permanent_address_barangay');
            $table->string('permanent_address_city');
            $table->string('permanent_address_province');
            $table->string('permanent_address_zip_code')->nullable();
            $table->string('father_full_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_address')->nullable();
            $table->string('father_contact_number')->nullable();
            $table->string('father_email')->nullable();
            $table->string('mother_full_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_address')->nullable();
            $table->string('mother_contact_number')->nullable();
            $table->string('mother_email')->nullable();            
            $table->string('guardian_full_name');
            $table->string('guardian_relationship');
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_address');
            $table->string('guardian_contact_number');
            $table->string('guardian_email')->nullable();
            $table->string('parents_or_guardian_average_income');
            $table->string('other_average_income')->nullable();
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
        Schema::dropIfExists('applicant_personal_informations');
    }
}
