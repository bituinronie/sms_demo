<?php

namespace App\Repositories\Admission\Miscellaneous;

use App\Repositories\BaseRepository;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\ActivityLog\ActivityLog;

class EmailUpdateAdmissionRepository extends BaseRepository
{
    public function execute($request, $priorityNumber){

		$personal = ApplicantPersonalInformation::where("id", "=", $this->getPersonalId($priorityNumber))->firstOrFail();
		
		// *** Initialized old data (used for: activity logs)
		$originalPersonal = ApplicantPersonalInformation::find($personal->id);

		// *** Update only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $personal->admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
		) {
			
			$personal->update([
				'email_address' => $request->emailAddress
			]);

			// *** Initialized updated data (used for: activity logs & displaying data)
			$updatedPersonal = ApplicantPersonalInformation::find($personal->id);

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "UPDATE",
				"module"  => "ADMISSION",
				"message" => "UPDATED THE EMAIL OF APPLICANT",
				"causeTo" => [
					"PRIORITY NUMBER" => $updatedPersonal->admission->priority_number,
					"FULL NAME"       => "{$updatedPersonal->last_name}, {$updatedPersonal->first_name}".($updatedPersonal->middle_name ? ' '.$updatedPersonal->middle_name:''),
					"BRANCH"          => $updatedPersonal->admission->branch->name,
				],
				"data"    => $this->activityChangedOnly($originalPersonal, $updatedPersonal)
			]);

		} else {

			return $this->error("You're not authorized to update this student's email");

		}
		
		return $this->success("Email Succesfully Updated", ["studentNumber" => $updatedPersonal->admission->priority_number]);
	}
}