<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department,
    App\Models\ActivityLog\ActivityLog;

class UpdateDepartmentRepository extends BaseRepository
{
    public function execute($request, $branchCode, $departmentCode) {

        $department = Department::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($departmentCode))->firstOrFail();

        // *** Initialized old data (used for: activity logs)
        $originalDepartment = Department::find($department->id);

        // *** Update only if user, department branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $department->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $department->update([
                "code"        => strtoupper($request->code),
                "name"        => strtoupper($request->name),
                "employee_id" => $request->employee ? $this->getEmployeeId($request->employee) : null,
                "type"        => strtoupper($request->type),
                "branch_id"   => $this->getBranchId($request->branch)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedDepartment = Department::find($department->id); 

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "DEPARTMENT",
                "message" => "UPDATED A DEPARTMENT",
                "causeTo" => $this->activityCauseTo($updatedDepartment, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalDepartment,
                    $updatedDepartment,
                    getForeign: [
                        'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                        'branch'   => ['code','name']
                    ],
                    ignored   : ['employee_id', 'branch_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this department");

        }

        return $this->success("Department Successfuly Updated", 
            $this->getShowData(
                $updatedDepartment, 
                getForeign: [
                    'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                    'branch'   => ['code','name']
                ]
            )
        );
    }
}