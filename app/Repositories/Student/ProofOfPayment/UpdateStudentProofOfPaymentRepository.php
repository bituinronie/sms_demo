<?php

namespace App\Repositories\Student\ProofOfPayment;

use App\Repositories\BaseRepository;

use App\Models\Accounting\ProofOfPayment,
    App\Models\ActivityLog\ActivityLog;

class UpdateStudentProofOfPaymentRepository extends BaseRepository
{
    public function execute($request, $paymentCode){

        $proofOfPayment           = ProofOfPayment::where('payment_code', '=', $paymentCode)->where('applicant_id', '=', $this->student()->applicant_id)->firstOrFail();
        $getStudentProofOfPayment = ProofOfPayment::where('applicant_id', '=', $this->student()->applicant_id)->get();
        $boolean                  = true;
        
        // *** Initialized old data (used for: activity logs)
        $originalProofOfPayment = ProofOfPayment::find($proofOfPayment->id);

        if (strtoupper($request->paymentOption) != 'OTHER') {

            if (strtoupper($request->paymentOption) != $proofOfPayment->payment_option) {
                
                foreach ($getStudentProofOfPayment as $key) {
                
                    if(
                        $key->payment_option   == strtoupper($request->paymentOption) &&
                        $key->education_level  == $this->student()->personal->admission->education_level &&
                        $key->grade_year_level == $this->student()->personal->admission->grade_year_level &&
                        $key->semester         == $this->student()->personal->admission->semester &&
                        $key->school_year      == $this->student()->personal->admission->school_year
                    ){
                        $boolean = false;
                        return $this->error("Can't update because this payment option is already been uploaded.");
                    }
                }
            }

            if ($boolean) {

                $this->update($this->student(), $request, $proofOfPayment, $originalProofOfPayment);

            }


        } elseif(strtoupper($request->paymentOption) == 'OTHER') {

            $this->update($this->student(), $request, $proofOfPayment, $originalProofOfPayment);

        }

        return $this->success("Payment Successfuly Updated", [
            "paymentCode" => $paymentCode,
            "lastName"    => $this->student()->personal->last_name,
            "firstName"   => $this->student()->personal->first_name,
            "middleName"  => $this->student()->personal->middle_name
        ]);
    }

    //*********************************************** DRY FUNCTION ***********************************************// 

    private function update($student, $request, $proofOfPayment, $originalProofOfPayment){

        $proofOfPayment->update([
            "payment_option"  => strtoupper($request->paymentOption) ?: $proofOfPayment->payment_option,
            "other"           => strtoupper($request->other) ?: null,
            "amount"          => $request->amount ?? $proofOfPayment->amount,
            "payment_status"  => "PENDING",
            "remark"          => "CURRENTLY BEING REVIEWED",
            "payment_receipt" => $request->hasFile('paymentReceipt') ?
                                    $this->updateFile(
                                        $this->studentFolder($student->student_number),
                                        $request->file('paymentReceipt'),
                                        $proofOfPayment->payment_receipt
                                    ) : $proofOfPayment->payment_receipt
        ]);

        ActivityLog::create([
            "student_id" => $this->student()->id,
            "action"     => "UPDATE",
            "module"     => "STUDENT",
            "message"    => "UPDATED PROOF OF PAYMENT RECEIPT",
            "causeTo"    => [
                "PRIORITY NUMBER" => $proofOfPayment->personal->admission->priority_number,
                "FULL NAME"       => "{$proofOfPayment->personal->last_name}, {$proofOfPayment->personal->first_name}".($proofOfPayment->personal->middle_name ? ' '.$proofOfPayment->personal->middle_name:''),
                "PAYMENT CODE"    => $proofOfPayment->payment_code,
            ],
            "data"       => $this->activityChangedOnly(
                $originalProofOfPayment, 
                $proofOfPayment, 
                file   : ['payment_receipt'],
                ignored: ['payment_status', 'remark', 'updated_at']
            )
        ]);
    }
}