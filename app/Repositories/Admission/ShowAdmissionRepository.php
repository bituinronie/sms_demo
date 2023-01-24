<?php

namespace App\Repositories\Admission;

use App\Repositories\BaseRepository;

use Arr;

use App\Models\Admission\ApplicantAdmission,
	App\Models\Admission\ApplicantEducationBackground,
	App\Models\Admission\ApplicantRequirement;

class ShowAdmissionRepository extends BaseRepository
{
    public function execute($priorityNumber){
		
		$admission   = ApplicantAdmission::where("applicant_id", "=", $this->getPersonalId($priorityNumber))->firstOrFail();
		$education   = ApplicantEducationBackground::where("applicant_id", "=", $admission->applicant_id)->firstOrFail();
		$requirement = ApplicantRequirement::where("applicant_id", "=", $admission->applicant_id)->firstOrFail();
		
		// *** Show only if student and user is same branch or if user is main branch
		if (
			$this->user()->employee->branch->id == $admission->branch->id || 
			$this->user()->employee->branch->type == "MAIN"
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