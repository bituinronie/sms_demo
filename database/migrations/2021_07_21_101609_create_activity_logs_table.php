<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('student_id')->nullable();
            $table->enum('action', ['CREATE', 'UPDATE', 'ARCHIVE', 'RESTORE', 'DELETE', 'LOGIN']);
            $table->enum('module', [
                'ACCOUNTING',
                'ADMISSION',
                'BASIC EDUCATION',
                'COLLEGE',
                'DEPARTMENT',
                'FACILITY',
                'FOREIGN',
                'HUMAN RESOURCE',
                'INFORMATION TECHNOLOGY SERVICE',
                'REGISTRAR',
                'SCHOLARSHIP',
                'STUDENT',
                'SYSTEM',
                'USER'
            ]);
            $table->string('message');
            $table->text('causeTo')->nullable();
            $table->text('data')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
