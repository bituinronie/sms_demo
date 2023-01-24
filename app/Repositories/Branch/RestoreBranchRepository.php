<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch,
	App\Models\ActivityLog\ActivityLog;

class RestoreBranchRepository extends BaseRepository
{
    public function execute($branchCode){
			
		// *** Restore only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$branch = Branch::onlyTrashed()->where('code', '=', $branchCode)->firstOrFail();

			$branch->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "SYSTEM",
				"message" => "RESTORED A BRANCH",
				"causeTo" => $this->activityCauseTo($branch, only: ['code', 'name'])
			]);

		} else {

			return $this->error("You're not authorized to restore this branch");

		}

		return $this->success("Branch Successfuly Restored", $this->getShowData($branch));
	}
}