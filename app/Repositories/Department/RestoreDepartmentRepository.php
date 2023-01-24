<?php

namespace App\Repositories\Department;

use App\Repositories\BaseRepository;

use App\Models\Department\Department,
	App\Models\ActivityLog\ActivityLog;

class RestoreDepartmentRepository extends BaseRepository
{
    public function execute($branchCode, $departmentCode){

		$department = Department::onlyTrashed()
		->where('branch_id', '=', $this->getBranchId($branchCode))
		->where('code', '=', strtoupper($departmentCode))->firstOrFail();

		// *** Restore only if user and department branch is same or if user is main branch
		if (
			$this->user()->employee->branch->id == $department->branch->id ||
			$this->user()->employee->branch->type == "MAIN"
		) {

			$department->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "DEPARTMENT",
				"message" => "RESTORED A DEPARTMENT",
				"causeTo" => $this->activityCauseTo($department, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
			]);

		} else {

			return $this->error("You're not authorized to restore this department");

		}

		return $this->success("Department Successfuly Restored",
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