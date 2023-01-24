<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department,
    App\Models\Employee\Employee,
    App\Models\Program\Program,
    App\Models\Subject\Subject,
    App\Models\ActivityLog\ActivityLog;

class ArchiveDepartmentRepository extends BaseRepository
{
    public function execute($branchCode, $departmentCode){

        $department = Department::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($departmentCode))->firstOrFail();

        // *** Archive only if user and department branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $department->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {
            
            // *** Don't archive if used by other module
            $employee = Employee::where('department_id', '=', $department->id)->get();
            $subject  = Subject::where('department_id', '=', $department->id)->get();
            $program  = Program::where('department_id', '=', $department->id)->get();

            if ($employee->isEmpty() || $subject->isEmpty() || $program->isEmpty()) {

                $department->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "DEPARTMENT",
                    "message" => "ARCHIVED A DEPARTMENT",
                    "causeTo" => $this->activityCauseTo($department, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
                ]);

            } elseif ($employee->isNotEmpty()) {

                return $this->error("Can't archive because this department is currently in use");
            }

        } else {

            return $this->error("You're not authorized to archive this department");

        }

        return $this->success("Department Successfuly Archived",
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