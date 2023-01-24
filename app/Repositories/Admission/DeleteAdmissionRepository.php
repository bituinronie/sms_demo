<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use App\Models\Admission\ApplicantPersonalInformation,
	App\Models\ActivityLog\ActivityLog;

class DeleteAdmissionRepository extends BaseRepository
{
    public function execute($priorityNumber){

		$personal = ApplicantPersonalInformation::onlyTrashed()->where("id", "=", $this->getPersonalId($priorityNumber))->firstOrFail();

		// *** Delete only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $personal->admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
		) {
			
			$this->deleteFolder($this->studentFolder($personal->admission->priority_number));

			$personal->forceDelete();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "DELETE",
				"module"  => "ADMISSION",
				"message" => "DELETED AN APPLICANT",
				"causeTo" => [
					"PRIORITY NUMBER" => $personal->admission->priority_number,
					"FULL NAME"       => "{$personal->last_name}, {$personal->first_name}".($personal->middle_name ? ' '.$personal->middle_name:''),
					"BRANCH"          => $personal->admission->branch->name,
					]
			]);

		} else {

			return $this->error("You're not authorized to delete this student");

		}
		
		return $this->success("Student Successfuly Deleted", ["studentNumber" => $priorityNumber]);
	}
}