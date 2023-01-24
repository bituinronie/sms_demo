<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department,
    App\Models\ActivityLog\ActivityLog;

class CreateDepartmentRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $department = Department::create([
                "code"        => strtoupper($request->code),
                "name"        => strtoupper($request->name),
                "employee_id" => $request->employee ? $this->getEmployeeId($request->employee) : null,
                "type"        => strtoupper($request->type),
                "branch_id"   => $this->getBranchId($request->branch)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "DEPARTMENT",
                "message" => "CREATED A DEPARTMENT",
                "data"    => 
                [
                    "new" => [
                        "CODE"     => $department->code,
                        "NAME"     => $department->name,
                        "TYPE"     => $department->type,
                        "EMPLOYEE" => $department->employee->employee_number ?? null,
                        "BRANCH"   => $department->branch->name
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a department");

        }

        return $this->success("Department Successfuly Created",
            $this->getShowData(
                $department, 
                getForeign: [
                    'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                    'branch'   => ['code','name']
                ]
            )
        );
    }
}