<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department;

class ShowDepartmentRepository extends BaseRepository
{
    public function execute($branchCode, $departmentCode){

        $department  = Department::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($departmentCode))->firstOrFail();

        // *** Show only if user and department branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $department->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Department Found", 
                $this->getShowData(
                    $department, 
                    getForeign: [
                        'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                        'branch'   => ['code','name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this department");

        } 
    }
}