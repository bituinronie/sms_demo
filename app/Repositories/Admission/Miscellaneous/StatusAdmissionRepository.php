<?php

namespace App\Repositories\Admission\Miscellaneous;

use App\Repositories\BaseRepository;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\Admission\ApplicantAdmission,
	App\Models\ActivityLog\ActivityLog;

class StatusAdmissionRepository extends BaseRepository
{
    public function execute($request, $priorityNumber){

		$personal = ApplicantPersonalInformation::where("id", "=", $this->getPersonalId($priorityNumber))->firstOrFail();
		
		// *** Initialized old data (used for: activity logs)
		$originalAdmission = ApplicantAdmission::where("applicant_id", "=", $personal->id)->firstOrFail();

		// *** Update status only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $personal->admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
		) {

			$personal->admission->update([
				'applicant_status' => strtoupper($request->applicantStatus),
				'remark'           => strtoupper($request->remark)
			]);

			$this->sendApplicantStatus(
				$personal->first_name,
				$personal->admission->applicant_status,
				$personal->email_address
			);

			// *** Initialized updated data (used for: activity logs & displaying data)
			$updatedAdmission = ApplicantAdmission::where("applicant_id", "=", $personal->id)->firstOrFail();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "UPDATE",
				"module"  => "ADMISSION",
				"message" => "UPDATED THE STATUS OF APPLICANT",
				"causeTo" => [
					"PRIORITY NUMBER" => $updatedAdmission->priority_number,
					"FULL NAME"       => "{$personal->last_name}, {$personal->first_name}".($personal->middle_name ? ' '.$personal->middle_name:''),
					"BRANCH"          => $updatedAdmission->branch->name,
				],
				"data"    => $this->activityChangedOnly($originalAdmission, $updatedAdmission)
			]);

		} else {

			return $this->error("You're not authorized to update this student's status");

		}
		
		
		return $this->success("Status Succesfully Updated", ["status" => $updatedAdmission->applicant_status, "remark" => $updatedAdmission->remark]);
	}
}