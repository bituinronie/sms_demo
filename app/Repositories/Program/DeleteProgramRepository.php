<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

use App\Models\Program\Program,
    App\Models\ActivityLog\ActivityLog;

class DeleteProgramRepository extends BaseRepository
{
    public function execute($branchCode, $programCode) {
            
        $program = Program::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($programCode))->firstOrFail();
        
        // *** Delete only if user and program branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $program->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $program->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "COLLEGE",
                "message" => "DELETED A PROGRAM",
                "causeTo" => $this->activityCauseTo($program, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this program");
        }

        return $this->success("Program Successfuly Deleted",
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