<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

use Arr;

use App\Models\Employee\Employee;

class ShowEmployeeRepository extends BaseRepository
{
    public function execute($employeeNumber){

        // *** Show only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $employee  = Employee::where('employee_number', '=', $employeeNumber)->firstOrFail();

        } else {

            return $this->error("You're not authorized to view this employee");

        }

        return $this->success("Employee Found", 
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