<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department;

class IndexDepartmentRepository extends BaseRepository
{
    public function execute() {

        // *** Show all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $department = Department::all();
            
        }
        // *** Show current branch data (current branch only)
        elseif($this->user()->employee->branch->type == "SUB"){

            $department = Department::where("branch_id", "=", $this->user()->employee->branch->id)->get();
            
        } else {

            return $this->error("You're not authorized to view all department");
            
        }

        return $this->success("List of All Department", $this->getIndexData(
            $department, 
            getForeign: [
                'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                'branch'   => ['code','name']
            ])
        );
    }

    
}