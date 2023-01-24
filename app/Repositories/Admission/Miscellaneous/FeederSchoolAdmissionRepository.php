<?php

namespace App\Repositories\Admission\Miscellaneous;

use App\Repositories\BaseRepository;

use Illuminate\Database\Eloquent\ModelNotFoundException,
    Illuminate\Database\QueryException;

use App\Models\Admission\ApplicantPersonalInformation;

class FeederSchoolAdmissionRepository extends BaseRepository
{
    public function execute($request){

        $personal = ApplicantPersonalInformation::
            join(
                'applicant_admissions', 
                'applicant_admissions.applicant_id', '=', 
                'applicant_personal_informations.id'
            )
            ->join(
                'applicant_education_backgrounds', 
                'applicant_education_backgrounds.applicant_id', '=', 
                'applicant_personal_informations.id'
            );

        $feeders = $this->feeder(
                    $personal,
                    $this->getBranchId($request->branch),
                    strtoupper($request->educationLevel),
                    strtoupper($request->semester),
                    date("Y-m-d", strtotime($request->startDate)),
                    date("Y-m-d", strtotime($request->endDate))
                );

        // *** Can use other branch feeder school if branch is main
        if ($this->user()->employee->branch->type == "MAIN") {
            
            return $this->success("Feeder School", [
                "SCHOOL" => $feeders,
                "TOTAL"  => array_sum($feeders)
            ]);
            
        }
        // *** Can use only current branch feeder school 
        elseif ($this->user()->employee->branch->type == "SUB" && $this->user()->employee->branch->id == $this->getBranchId($request->branch)) {
            
            return $this->success("Feeder School", [
                "SCHOOL" => $feeders,
                "TOTAL"  => array_sum($feeders)
            ]);

        } else {

            return $this->error("You're not authorized to view this feeders");

        }
	}



    //*********************************************** CUSTOM FUNCTION ***********************************************//

    private function feeder($personal, $branch, $educationLevel, $semester, $startDate, $endDate){

        $schoolCount = $feeder = [];

        // *** Display school with all education level in all semester
        if ($educationLevel == 'ALL' &&  $semester == 'ALL') {

            $feeder = $personal->where("branch_id", "=", $branch)
                    ->whereBetween("created_at", [$startDate, $endDate])
                    ->get();

        }
        // *** Display school with specific education level in all semester
        elseif ($educationLevel != 'ALL' && $semester == 'ALL') {

            $feeder = $personal->where("branch_id", "=", $branch)
                    ->where("education_level", "=", $educationLevel)
                    ->whereBetween("created_at", [$startDate, $endDate])
                    ->get();

        }
        // *** Display school with all education level in specific semester
        elseif ($educationLevel == 'ALL' && $semester != 'ALL') {

            $feeder = $personal->where("branch_id", "=", $branch)
                    ->where("semester", "=", $semester)
                    ->whereBetween("created_at", [$startDate, $endDate])
                    ->get();

        }
        // *** Display school in specific education level and specific semester
        elseif ($educationLevel != 'ALL' && $semester != 'ALL') {

            $feeder = $personal->where("branch_id", "=", $branch)
                    ->where("education_level", "=", $educationLevel)
                    ->where("semester", "=", $semester)
                    ->whereBetween("created_at", [$startDate, $endDate])
                    ->get();

        }

        foreach ($feeder as $key => $value) {
            $schoolCount[$key] = $value->previous_school;
        }

        return array_count_values($schoolCount);
    }
}