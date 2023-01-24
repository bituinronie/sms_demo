<?php

namespace App\Repositories\Accounting\ProofOfPayment;

use App\Repositories\BaseRepository;

use App\Models\Accounting\ProofOfPayment,
	App\Models\ActivityLog\ActivityLog;

class ArchiveProofOfPaymentRepository extends BaseRepository
{
    public function execute($paymentCode){

		$proofOfPayment = ProofOfPayment::where('payment_code', '=', $paymentCode)->firstOrFail();

		if ($proofOfPayment->count()) {

			// *** Archive only if user and student branch is same or if user is main branch
			if (
				$this->user()->employee->branch->id == $proofOfPayment->personal->admission->branch->id ||
				$this->user()->employee->branch->type == "MAIN"
			) {

				$proofOfPayment->delete();

				ActivityLog::create([
					"user_id" => $this->user()->id,
					"action"  => "ARCHIVE",
					"module"  => "ACCOUNTING",
					"message" => "ARCHIVED PROOF OF PAYMENT",
					"causeTo"    => [
						"PAYMENT CODE"    => $proofOfPayment->payment_code,
						"PRIORITY NUMBER" => $proofOfPayment->personal->admission->priority_number,
						"FULL NAME"       => "{$proofOfPayment->personal->last_name}, {$proofOfPayment->personal->first_name}".($proofOfPayment->personal->middle_name ? ' '.$proofOfPayment->personal->middle_name:''),
						"BRANCH"          => $proofOfPayment->personal->admission->branch->name,
					],
				]);

			} else {

				return $this->error("You're not authorized to archive this proof of payment");

			}
		}

		return $this->success("Proof Of Payment Successfuly Archived", ["paymentCode" => $paymentCode]);
	}
}