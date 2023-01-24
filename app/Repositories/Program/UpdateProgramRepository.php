<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

use App\Models\Program\Program,
    App\Models\ActivityLog\ActivityLog;

class UpdateProgramRepository extends BaseRepository
{
    public function execute($request, $branchCode, $programCode) {
            
        $program = Program::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($programCode))->firstOrFail();

        // *** Initialized old data (used for: activity logs)
        $originalProgram = Program::find($program->id); 

        // *** Update only if user, program branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $program->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $program->update([
                "code"          => strtoupper($request->code),
                "name"          => strtoupper($request->name),
                "type"          => strtoupper($request->type),
                "duration"      => $request->duration,
                "employee_id"   => $request->employee ? $this->getEmployeeId($request->employee) : null,
                "department_id" => $this->getDepartmentId($request->department),
                "branch_id"     => $this->getBranchId($request->branch)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedProgram = Program::find($program->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "COLLEGE",
                "message" => "UPDATED A PROGRAM",
                "causeTo" => $this->activityCauseTo($updatedProgram, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalProgram,
                    $updatedProgram,
                    getForeign: [
                        'employee'   => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                        'department' => ['code', 'name'],
                        'branch'     => ['code','name']
                    ],
                    ignored   : ['employee_id', 'department_id', 'branch_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this program");

        }


        return $this->success("Program Successfuly Updated",
            $this->getShowData(
                $updatedProgram, 
                getForeign: [
                    'employee'   => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                    'department' => ['code', 'name'],
                    'branch'     => ['code','name']
                ]
            )
        );
    }
}