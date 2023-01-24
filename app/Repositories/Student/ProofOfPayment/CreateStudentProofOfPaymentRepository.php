<?php

namespace App\Repositories\Student\ProofOfPayment;

use App\Repositories\BaseRepository;

use App\Models\Accounting\ProofOfPayment,
    App\Models\ActivityLog\ActivityLog;

class CreateStudentProofOfPaymentRepository extends BaseRepository
{
    public function execute($request) {

        $proofOfPayment = ProofOfPayment::where('applicant_id', '=', $this->student()->applicant_id)->get();
        $boolean = true;

        if ($proofOfPayment->isNotEmpty()) {

            if (strtoupper($request->paymentOption) != 'OTHER') {

                foreach ($proofOfPayment as $key) {
                    
                    if(
                        $key->payment_option   == strtoupper($request->paymentOption) &&
                        $key->education_level  == $this->student()->personal->admission->education_level &&
                        $key->grade_year_level == $this->student()->personal->admission->grade_year_level &&
                        $key->semester         == $this->student()->personal->admission->semester &&
                        $key->school_year      == $this->student()->personal->admission->school_year
                    ){
                        $boolean = false;
                        return $this->error("This payment option is already been uploaded. If there are changes, Just kindly update the current entry you've submitted");
                    }
                }

                if ($boolean) {

                    $this->create($this->student(), $request);

                }


            } elseif (strtoupper($request->paymentOption) == 'OTHER') {

                $this->create($this->student(), $request);

            }

        } else {

            $this->create($this->student(), $request);

        }

        return $this->success("Proof Of Payment Successfuly Created", ["priorityNumber" => $this->student()->student_number]);
    }


   //*********************************************** DRY FUNCTION ***********************************************// 

    private function create($student, $request){
        try {

            $proofOfPayment = ProofOfPayment::create([
                                "applicant_id"    => $student->applicant_id,
                                "payment_code"    => $this->paymentCode(),
                                "payment_option"  => strtoupper($request->paymentOption),
                                "other"          => strtoupper($request->other) ?: null,
                                "amount"          => $request->amount,
                                "payment_status"  => "PENDING",
                                "remark"          => "CURRENTLY BEING REVIEWED",
                                "payment_receipt" => $request->hasFile('paymentReceipt') ?
                                                        $this->storeFile(
                                                            $this->studentFolder($student->student_number),
                                                            $request->file('paymentReceipt')
                                                        ) : "No File Uploaded",
                                "education_level"  => $student->personal->admission->education_level,
                                "grade_year_level" => $student->personal->admission->grade_year_level,
                                "semester"         => $student->personal->admission->semester,
                                "school_year"      => $student->personal->admission->school_year,
                            ]);


            ActivityLog::create([
                "student_id" => $this->student()->id,
                "action"     => "CREATE",
                "module"     => "STUDENT",
                "message"    => "SUBMITTED PROOF OF PAYMENT RECEIPT",
                "data"       => 
                [
                    "new" => [
                        "PRIORITY NUMBER" => $proofOfPayment->personal->admission->priority_number,
                        "FULL NAME"       => "{$proofOfPayment->personal->last_name}, {$proofOfPayment->personal->first_name}".($proofOfPayment->personal->middle_name ? ' '.$proofOfPayment->personal->middle_name:''),
                        "PAYMENT CODE"    => $proofOfPayment->payment_code,
                        "PAYMENT OPTION"  => $proofOfPayment->payment_option,
                        "OTHER"           => $proofOfPayment->other,
                        "AMOUNT"          => $proofOfPayment->amount,
                        "PAYMENT STATUS"  => $proofOfPayment->payment_status
                    ]
                ]
            ]);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage()); 
        }
    }
}