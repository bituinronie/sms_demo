<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use App\Models\Admission\ApplicantPersonalInformation;

class ListAdmissionRepository extends BaseRepository
{
    public function execute(){

		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$personal = ApplicantPersonalInformation::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$personal = ApplicantPersonalInformation::onlyTrashed()->
			join(
				'applicant_admissions', 
				'applicant_admissions.applicant_id', '=', 
				'applicant_personal_informations.id'
			)->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive students");
			
		}

		return $this->success("List of All Archive Applicant", $this->listAdmission($personal));
	}


	//*********************************************** CUSTOM FUNCTION ***********************************************//

	private function listAdmission($personal){

		foreach($personal as $key => $value){
			$data[$key] = [
				"priorityNumber"  => $value->admission->priority_number,
				"lastName"        => $value->last_name,
				"firstName"       => $value->first_name,
				"middleName"      => $value->middle_name,
				"educationLevel"  => $value->admission->education_level,
				"gradeYearLevel"  => $value->admission->grade_year_level,
				"programOrStrand" => $value->admission->program->code ?? $value->admission->strand->code ?? null,
				"applicantStatus" => $value->admission->applicant_status,
				"semester"        => $value->admission->semester,
				"branch"          => $value->admission->branch->name ?? null,
				"schoolYear"      => $value->admission->school_year,
				"createdAt"       => "{$value->created_at}",
			];
		}

		return $data ?? [];
	}
}