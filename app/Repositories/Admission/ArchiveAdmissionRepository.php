<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\Accounting\ProofOfPayment,
	App\Models\ActivityLog\ActivityLog;

class ArchiveAdmissionRepository extends BaseRepository
{
    public function execute($priorityNumber){

		$personal = ApplicantPersonalInformation::where("id", "=", $this->getPersonalId($priorityNumber))->firstOrFail();
		
		// *** Archive only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $personal->admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
		) {

			$proofOfPayment = ProofOfPayment::where('applicant_id', '=', $this->getPersonalId($priorityNumber))->get();
		
			if ($proofOfPayment->isEmpty()) {

				$personal->admission->update([
					'applicant_status' => 'ARCHIVED',
					'remark'           => 'We haven\'t heard from you for a while, so we archived your data to allot space for new applicants.'
				]);
	
				$personal->delete();

				ActivityLog::create([
					"user_id" => $this->user()->id,
					"action"  => "ARCHIVE",
					"module"  => "ADMISSION",
					"message" => "ARCHIVED AN APPLICANT",
					"causeTo" => [
						"PRIORITY NUMBER" => $personal->admission->priority_number,
						"FULL NAME"       => "{$personal->last_name}, {$personal->first_name}".($personal->middle_name ? ' '.$personal->middle_name:''),
						"BRANCH"          => $personal->admission->branch->name,
					]
				]);

			} elseif ($proofOfPayment->isNotEmpty()) {

				return $this->error("Can't archive because this student has a proof of payment data");
			}

		} else {

			return $this->error("You're not authorized to archive this student");

		}

		return $this->success("Student Successfuly Archived", ["studentNumber" => $priorityNumber]);
	}
}