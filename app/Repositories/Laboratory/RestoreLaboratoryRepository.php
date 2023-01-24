<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory,
	App\Models\ActivityLog\ActivityLog;

class RestoreLaboratoryRepository extends BaseRepository
{
    public function execute($branchCode, $laboratoryCode){

		$laboratory = Laboratory::onlyTrashed()
		->where('branch_id', '=', $this->getBranchId($branchCode))
		->where('code', '=', strtoupper($laboratoryCode))->firstOrFail();

		// *** Restore only if user and laboratory branch is same or if user is main branch
		if (
			$this->user()->employee->branch->id == $laboratory->branch->id ||
			$this->user()->employee->branch->type == "MAIN"
		) {

			$laboratory->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "FACILITY",
				"message" => "RESTORED A LABORATORY",
				"causeTo" => $this->activityCauseTo($laboratory, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
			]);

		} else {

			return $this->error("You're not authorized to restore this laboratory");
		}

		return $this->success("Laboratory Successfuly Restored",
			$this->getShowData(
				$laboratory, 
				getForeign: [
					'branch' => ['code','name']
				]
			)
		);
	}
}