<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

use App\Models\Employee\Employee,
    App\Models\Department\Department,
    App\Models\Program\Program,
	App\Models\ActivityLog\ActivityLog;

class ArchiveEmployeeRepository extends BaseRepository
{
    public function execute($employeeNumber){

        // *** Archive only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $employee = Employee::where('employee_number', '=', $employeeNumber)->firstOrFail();

            // *** Don't archive if used by other module
            $department = Department::where('employee_id', '=', $employee->id)->get();
            $program    = Program::where('employee_id', '=', $employee->id)->get();

            if ($department->isEmpty()) {

                $employee->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "HUMAN RESOURCE",
                    "message" => "ARCHIVED AN EMPLOYEE",
                    "causeTo" => [
                        "EMPLOYEE NUMBER" => $employee->employee_number,
                        "FULL NAME"       => "{$employee->last_name}, {$employee->first_name}".($employee->middle_name ? ' '.$employee->middle_name:''),
                        "TYPE"            => $employee->type,
                        "DEPARTMENT"      => $employee->department->name,
                        "BRANCH"          => $employee->branch->name
                    ]
                ]);

            } elseif ($department->isNotEmpty()) {

                return $this->error("Can't archive because this employee is currently a department head");
            }
            

        } else {

            return $this->error("You're not authorized to archive this employee");

        }

        return $this->success("Employee Successfuly Archived",
            $this->getShowData(
                $employee, 
                getForeign: [
                    'department' => ['code', 'name'],
                    'branch'     => ['code','name']
                ]
            )
        );
	}
}