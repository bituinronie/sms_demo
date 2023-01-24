<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department;

class ListDepartmentRepository extends BaseRepository
{
    public function execute(){
			
        // *** List all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $department = Department::onlyTrashed()->get();
            
        }
        // *** List current branch data (current branch only)
        elseif($this->user()->employee->branch->type == "SUB"){
            
            $department = Department::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
            
        } else {

            return $this->error("You're not authorized to view all archive departments");
            
        }

        return $this->success("List of All Archive Department", $this->getListData(
            $department, 
            getForeign: [
                'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                'branch'   => ['code','name']
            ])
        );
	}
}