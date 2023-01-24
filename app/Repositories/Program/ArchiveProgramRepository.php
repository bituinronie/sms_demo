<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

use App\Models\Program\Program,
    App\Models\Admission\ApplicantAdmission,
    App\Models\ActivityLog\ActivityLog;

class ArchiveProgramRepository extends BaseRepository
{
    public function execute($branchCode, $programCode){

        $program = Program::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($programCode))->firstOrFail();

        // *** Archive only if user and program branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $program->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // *** Don't archive if used by other module
            $admission = ApplicantAdmission::where('program_id', '=', $program->id)->get();

            if ($admission->isEmpty()) {

                $program->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "COLLEGE",
                    "message" => "ARCHIVED A PROGRAM",
                    "causeTo" => $this->activityCauseTo($program, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
                ]);

            } elseif ($admission->isNotEmpty()) {

                return $this->error("Can't archive because this program is currently in use");
            }

        } else {

            return $this->error("You're not authorized to archive this program");

        }

        return $this->success("Program Successfuly Archived",
            $this->getShowData(
                $program, 
                getForeign: [
                    'employee'   => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                    'department' => ['code', 'name'],
                    'branch'     => ['code','name']
                ]
            )
        ); 
	}
}