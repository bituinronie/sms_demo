<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department,
	App\Models\ActivityLog\ActivityLog;

class DeleteDepartmentRepository extends BaseRepository
{
    public function execute($branchCode, $departmentCode){
            
		$department = Department::onlyTrashed()
		->where('branch_id', '=', $this->getBranchId($branchCode))
		->where('code', '=', strtoupper($departmentCode))->firstOrFail();
		

		// *** Delete only if user and department branch is same or if user is main branch
		if (
			$this->user()->employee->branch->id ==  $department->branch->id ||
			$this->user()->employee->branch->type == "MAIN"
		) {

			$department->forceDelete();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "DELETE",
				"module"  => "DEPARTMENT",
				"message" => "DELETED A DEPARTMENT",
				"causeTo" => $this->activityCauseTo($department, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
			]);

		} else {

			return $this->error("You're not authorized to delete this department");

		}

		return $this->success("Department Successfuly Deleted",
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