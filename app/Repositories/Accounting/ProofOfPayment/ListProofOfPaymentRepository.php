<?php

namespace App\Repositories\Accounting\ProofOfPayment;

use App\Repositories\BaseRepository;

use App\Models\Accounting\ProofOfPayment;

class ListProofOfPaymentRepository extends BaseRepository
{
    public function execute(){

        // *** Show all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $proofOfPayment = ProofOfPayment::onlyTrashed()->get();
            
        }
        // *** Show current branch data (current branch only)
        elseif($this->user()->employee->branch->type == "SUB"){
            
            $proofOfPayment = ProofOfPayment::onlyTrashed()->
            join(
                'applicant_personal_informations', 
                'applicant_personal_informations.id', '=',
                'accounting_proof_of_payments.applicant_id'
            )->join(
                'applicant_admissions', 
                'applicant_admissions.applicant_id', '=',
                'accounting_proof_of_payments.applicant_id'
            )->where("branch_id", "=", $this->user()->employee->branch->id)->get();

        } else {

            return $this->error("You're not authorized to view all archive proof of payments");
            
        }

        return $this->success("List of All Archive Proof Of Payment", $this->listProofOfPayment($proofOfPayment));
	}
    

	//*********************************************** CUSTOM FUNCTION ***********************************************//

    private function listProofOfPayment($proofOfPayment){

        foreach ($proofOfPayment as $key => $value) {
            $data[$key] = [
                "priorityNumber" => $value->personal->admission->priority_number,
                "lastName"       => $value->personal->last_name,
                "firstName"      => $value->personal->first_name,
                "middleName"     => $value->personal->middle_name,
                "paymentCode"    => $value->payment_code,
                "paymentOption"  => $value->payment_option,
                "other"          => $value->other,
                "amount"         => $value->amount,
                "paymentStatus"  => $value->payment_status,
                "remark"         => $value->remark,
                "paymentReceipt" => $value->payment_receipt,
                "educationLevel" => $value->education_level,
                "gradeYearLevel" => $value->grade_year_level,
                "semester"       => $value->semester,
                "schoolYear"     => $value->school_year,
                "branchName"     => $value->personal->admission->branch->name,
                "createdAt"      => $value->created_at,
                "updatedAt"      => $value->updated_at,
            ];
        }

        return $data ?? [];
    }
}