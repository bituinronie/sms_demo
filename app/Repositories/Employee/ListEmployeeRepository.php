<?php

namespace App\Repositories\Employee;

use App\Repositories\BaseRepository;

use App\Models\Employee\Employee;

class ListEmployeeRepository extends BaseRepository
{
    public function execute(){
			
		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$employee = Employee::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$employee = Employee::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive employee");
			
		}

		return $this->success("List of All Archive Employee", $this->getListData(
			$employee,
			getForeign: [
                'department' => ['code','name'],
                'branch'     => ['code','name']
            ],
			only: [
				'employee_number', 
				'last_name', 
				'first_name', 
				'middle_name', 
				'type'
			])
		);
	}
}