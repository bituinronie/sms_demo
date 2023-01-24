<?php

namespace App\Repositories\Accounting\ProofOfPayment\Miscellaneous;

use App\Repositories\BaseRepository;

use App\Models\Accounting\ProofOfPayment,
	App\Models\ActivityLog\ActivityLog;

class StatusProofOfPaymentRepository extends BaseRepository
{
    public function execute($request, $paymentCode){
			
		$proofOfPayment = ProofOfPayment::where('payment_code', '=', $paymentCode)->firstOrFail();
		
		// *** Initialized old data (used for: activity logs)
		$originalProofOfPayment = ProofOfPayment::find($proofOfPayment->id);

		if ($proofOfPayment->count()) {

			// *** Archive only if user and student branch is same or if user is main branch
			if (
				$this->user()->employee->branch->id == $proofOfPayment->personal->admission->branch->id ||
				$this->user()->employee->branch->type == "MAIN"
			) {

				$proofOfPayment->update([
					'payment_status' => strtoupper($request->paymentStatus),
					'remark'         => strtoupper($request->remark)
				]);

				// *** Initialized updated data (used for: activity logs & displaying data)
				$updatedProofOfPayment = ProofOfPayment::find($proofOfPayment->id);

				ActivityLog::create([
					"user_id" => $this->user()->id,
					"action"  => "UPDATE",
					"module"  => "ACCOUNTING",
					"message" => "UPDATED PROOF OF PAYMENT STATUS",
					"causeTo" => [
						"PAYMENT CODE"    => $proofOfPayment->payment_code,
						"PRIORITY NUMBER" => $proofOfPayment->personal->admission->priority_number,
						"FULL NAME"       => "{$proofOfPayment->personal->last_name}, {$proofOfPayment->personal->first_name}".($proofOfPayment->personal->middle_name ? ' '.$proofOfPayment->personal->middle_name:''),
						"BRANCH"          => $proofOfPayment->personal->admission->branch->name,
					],
					"data"    => $this->activityChangedOnly($originalProofOfPayment, $updatedProofOfPayment)
				]);


			} else {

				return $this->error("You're not authorized to update this proof of payment status");

			}
		}
		
		return $this->success("Status Succesfully Updated", ["status" => $updatedProofOfPayment->payment_status, "remark" => $updatedProofOfPayment->remark]);
	}
}