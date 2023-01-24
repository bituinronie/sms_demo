<?php

namespace App\Repositories\InformationTechnologyServices\Student;

use App\Repositories\BaseRepository;

use App\Models\Student\StudentAccount;

class IndexStudentAccountRepository extends BaseRepository
{
    public function execute() {

		// *** Show all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$studentAccount = StudentAccount::join(
				'applicant_personal_informations', 
				'applicant_personal_informations.id', '=', 
				'student_accounts.applicant_id'
			)->get();
			
		}
		// *** Show current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$studentAccount = StudentAccount::join(
				'applicant_personal_informations', 
				'applicant_personal_informations.id', '=', 
				'student_accounts.applicant_id'
			)->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all student account");
			
		}

		return $this->success("List of All Student Account", $this->indexStudentAccount($studentAccount));
    }

    //*********************************************** CUSTOM FUNCTION ***********************************************//

	private function indexStudentAccount($studentAccount){

		foreach($studentAccount as $key => $value){
			$data[$key] = [
				"studentNumber"  => $value->student_number,
				"lastName"        => $value->personal->last_name,
				"firstName"       => $value->personal->first_name,
				"middleName"      => $value->personal->middle_name,
				"educationLevel"  => $value->personal->admission->education_level,
				"gradeYearLevel"  => $value->personal->admission->grade_year_level,
				"programOrStrand" => $value->personal->admission->program->code ?? $value->personal->admission->strand->code ?? null,
				"applicantStatus" => $value->personal->admission->applicant_status,
				"semester"        => $value->personal->admission->semester,
				"branch"          => $value->personal->admission->branch->name ?? null,
				"schoolYear"      => $value->personal->admission->school_year,
				"createdAt"       => "{$value->created_at}",
			];
		}

		return $data ?? [];
	}
}