<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->enum('type', ['PROFESSIONAL EDUCATION', 'GENERAL EDUCATION', 'NSTP']);
            $table->tinyInteger('lecture_unit');
            $table->float('lecture_hour');
            $table->tinyInteger('laboratory_unit');
            $table->float('laboratory_hour');
            $table->foreignId('branch_id');
            $table->foreignId('laboratory_id')->nullable();
            $table->foreignId('department_id');
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
        Schema::dropIfExists('subjects');
    }
}
