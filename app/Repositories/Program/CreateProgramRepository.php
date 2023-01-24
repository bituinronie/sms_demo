<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

use App\Models\Program\Program,
    App\Models\ActivityLog\ActivityLog;

class CreateProgramRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $program = Program::create([
                "code"          => strtoupper($request->code),
                "name"          => strtoupper($request->name),
                "type"          => strtoupper($request->type),
                "duration"      => $request->duration,
                "employee_id"   => $request->employee ? $this->getEmployeeId($request->employee) : null,
                "department_id" => $this->getDepartmentId($request->department),
                "branch_id"     => $this->getBranchId($request->branch)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "COLLEGE",
                "message" => "CREATED A PROGRAM",
                "data"    => 
                [
                    "new" => [
                        "CODE"       => $program->code,
                        "NAME"       => $program->name,
                        "TYPE"       => $program->type,
                        "DURATION"   => $program->duration,
                        "EMPLOYEE"   => $program->employee->employee_number ?? null,
                        "DEPARTMENT" => $program->department->name,
                        "BRANCH"     => $program->branch->name
                    ]
                ]
            ]);
            
        } else {

            return $this->error("You're not authorized to create a program");
        }

        return $this->success("Program Successfuly Created",
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