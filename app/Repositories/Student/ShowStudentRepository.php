<?php

namespace App\Repositories\Student;

use App\Repositories\BaseRepository;

use Arr;

use App\Models\Admission\ApplicantAdmission,
	App\Models\Admission\ApplicantEducationBackground,
	App\Models\Admission\ApplicantRequirement;

class ShowStudentRepository extends BaseRepository
{
    public function execute(){

		$admission   = ApplicantAdmission::where("applicant_id", "=", $this->student()->personal->id)->firstOrFail();
		$education   = ApplicantEducationBackground::where("applicant_id", "=", $admission->applicant_id)->firstOrFail();
		$requirement = ApplicantRequirement::where("applicant_id", "=", $admission->applicant_id)->firstOrFail();
		
		
		// *** Show only if student and student user account is same branch and same priority/student number
		if (
			$this->student()->personal->admission->branch->id == $admission->branch->id &&
			$this->student()->student_number == $admission->priority_number
		) {

			return $this->success("Show Profile", Arr::collapse([
				$this->getShowData(
					$admission, 
					getForeign: [
						'branch'  => ['code', 'name'],
						'program' => ['code', 'name'],
						'strand'  => ['code', 'name'],
					]
				),
				$this->getShowData($admission->personal),
				$this->getShowData($education),
				$this->getShowData($requirement)
			]));

		} else {

			return $this->error("You're not authorized to view this student");
		}
	}
}