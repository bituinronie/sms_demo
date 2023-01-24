<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

use App\Models\Employee\Employee,
	App\Models\ActivityLog\ActivityLog;

class RestoreEmployeeRepository extends BaseRepository
{
    public function execute($employeeNumber){

        // *** Restore only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $employee = Employee::onlyTrashed()->where('employee_number', '=', $employeeNumber)->firstOrFail();

            $employee->restore();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "RESTORE",
                "module"  => "HUMAN RESOURCE",
                "message" => "RESTORED AN EMPLOYEE",
                "causeTo" => [
                    "EMPLOYEE NUMBER" => $employee->employee_number,
                    "FULL NAME"       => "{$employee->last_name}, {$employee->first_name}".($employee->middle_name ? ' '.$employee->middle_name:''),
                    "TYPE"            => $employee->type,
                    "DEPARTMENT"      => $employee->department->name,
                    "BRANCH"          => $employee->branch->name
                ]
            ]);


        } else {

            return $this->error("You're not authorized to restore this employee");

        }

        return $this->success("Employee Successfuly Restored",
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