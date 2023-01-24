<?php

namespace App\Repositories\Student\ProofOfPayment;

use App\Repositories\BaseRepository;

use App\Models\Accounting\ProofOfPayment;

class IndexStudentProofOfPaymentRepository extends BaseRepository
{
    public function execute($applicantId) {

        $proofOfPayment = ProofOfPayment::where('applicant_id', '=', $applicantId)->get();

        if($proofOfPayment->isNotEmpty()){

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
        }

        return $this->success("List of All Proof Of Payment", $data ?? []);
    }
}