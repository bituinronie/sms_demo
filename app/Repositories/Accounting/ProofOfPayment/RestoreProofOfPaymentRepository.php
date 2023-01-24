<?php

namespace App\Repositories\Accounting\ProofOfPayment;

use App\Repositories\BaseRepository;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Accounting\ProofOfPayment,
    App\Models\ActivityLog\ActivityLog;

class RestoreProofOfPaymentRepository extends BaseRepository
{
    public function execute($paymentCode){
        
        $proofOfPayment           = ProofOfPayment::onlyTrashed()->where('payment_code', '=', $paymentCode)->firstOrFail();
        $getStudentProofOfPayment = ProofOfPayment::where('applicant_id', '=', $proofOfPayment->applicant_id)->get();
        $boolean                  = true;

        if ($proofOfPayment->onlyTrashed()->count()) {
            
            // *** Restore only if user and student branch is same or if user is main branch
            if (
                $this->user()->employee->branch->id == $proofOfPayment->personal->admission->branch->id ||
                $this->user()->employee->branch->type == "MAIN"
            ) {

                if (strtoupper($proofOfPayment->payment_option) != 'OTHER') {

                    foreach ($getStudentProofOfPayment as $key) {
    
                        if(
                            $key->payment_option   == strtoupper($proofOfPayment->payment_option) &&
                            $key->education_level  == $key->personal->admission->education_level &&
                            $key->grade_year_level == $key->personal->admission->grade_year_level &&
                            $key->semester         == $key->personal->admission->semester &&
                            $key->school_year      == $key->personal->admission->school_year
                        ){
                            $boolean = false;
                            return $this->error("Can't restore because this payment option is already existing in current payments.");
                        }
                    }
    
                    if ($boolean) {
    
                        $proofOfPayment->restore();

                        ActivityLog::create([
                            "user_id" => $this->user()->id,
                            "action"  => "RESTORE",
                            "module"  => "ACCOUNTING",
                            "message" => "RESTORED PROOF OF PAYMENT",
                            "causeTo" => [
                                "PAYMENT CODE"    => $proofOfPayment->payment_code,
                                "PRIORITY NUMBER" => $proofOfPayment->personal->admission->priority_number,
                                "FULL NAME"       => "{$proofOfPayment->personal->last_name}, {$proofOfPayment->personal->first_name}".($proofOfPayment->personal->middle_name ? ' '.$proofOfPayment->personal->middle_name:''),
                                "BRANCH"          => $proofOfPayment->personal->admission->branch->name,
                            ],
                        ]);
    
                    }
    
    
                } elseif(strtoupper($proofOfPayment->payment_option) == 'OTHER') {
    
                    $proofOfPayment->restore();

                    ActivityLog::create([
                        "user_id" => $this->user()->id,
                        "action"  => "RESTORE",
                        "module"  => "ACCOUNTING",
                        "message" => "RESTORED PROOF OF PAYMENT",
                        "data"    => 
                        [
                            "old" => [
                                "PAYMENT CODE"    => $proofOfPayment->payment_code,
                                "PRIORITY NUMBER" => $proofOfPayment->personal->admission->priority_number,
                                "FULL NAME"       => "{$proofOfPayment->personal->last_name}, {$proofOfPayment->personal->first_name}".($proofOfPayment->personal->middle_name ? ' '.$proofOfPayment->personal->middle_name:''),
                                "BRANCH"          => $proofOfPayment->personal->admission->branch->name,
                            ]
                        ]
                    ]);
    
                }

            } else {

                return $this->error("You're not authorized to restore this proof of payment");

            }
        }
        

        return $this->success("Proof Of Payment Successfuly Restored", ["paymentCode" => $paymentCode]);
	}
}