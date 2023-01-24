<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->enum('type', ['TEACHING', 'NON-TEACHING', 'DEAN'])->default('NON-TEACHING');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->integer('age');
            $table->string('birth_date');
            $table->string('birth_place');
            $table->string('mobile_number')->nullable();
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
            $table->foreignId('department_id');
            $table->foreignId('branch_id');
            $table->string('image_id_front')->nullable();
            $table->string('image_id_back')->nullable();
            $table->string('image_signature')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
