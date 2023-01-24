<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\ActivityLog\ActivityLog;

class RestoreAdmissionRepository extends BaseRepository
{
    public function execute($priorityNumber){

		$personal  = ApplicantPersonalInformation::onlyTrashed()->where("id", "=", $this->getPersonalId($priorityNumber))->firstOrFail();

		// *** Restore only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $personal->admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
		) {
			
			$personal->admission->update([
				'applicant_status' => 'PENDING',
				'remark'           => 'Your information has been received! Kindly wait for the admission team to verify and accept your information.'
			]);

			$personal->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "ADMISSION",
				"message" => "RESTORED AN APPLICANT",
				"causeTo" => [
					"PRIORITY NUMBER" => $personal->admission->priority_number,
					"FULL NAME"       => "{$personal->last_name}, {$personal->first_name}".($personal->middle_name ? ' '.$personal->middle_name:''),
					"BRANCH"          => $personal->admission->branch->name,
				]
			]);

		} else {

			return $this->error("You're not authorized to restore this student");

		}

		return $this->success("Student Successfuly Restored", ["studentNumber" => $priorityNumber]);
	}
}