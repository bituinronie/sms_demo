<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingProofOfPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_proof_of_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id');
            $table->string('payment_code');
            $table->enum('payment_option', ['ENTRANCE FEE', 'PRELIM', 'MIDTERM', 'PRE-FINAL', 'FINAL', 'FULL PAYMENT',  'OTHER']);
            $table->string('other')->nullable();
            $table->float('amount',9,2);
            $table->enum('payment_status', ['PENDING', 'ACCEPTED', 'DENIED']);
            $table->string('remark')->nullble();
            $table->string('payment_receipt');
            $table->string('education_level')->nullable();
            $table->string('grade_year_level')->nullable();
            $table->string('semester')->nullable();
            $table->string('school_year')->nullable();
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
        Schema::dropIfExists('accounting_proof_of_payments');
    }
}
