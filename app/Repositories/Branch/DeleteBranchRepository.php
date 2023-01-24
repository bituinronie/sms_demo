<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch,
	App\Models\ActivityLog\ActivityLog;

class DeleteBranchRepository extends BaseRepository
{
    public function execute($branchCode) {
            
		// *** Delete only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$branch = Branch::onlyTrashed()->where('code', '=', $branchCode)->firstOrFail();

			$branch->forceDelete();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "DELETE",
				"module"  => "SYSTEM",
				"message" => "DELETED A BRANCH",
				"causeTo" => $this->activityCauseTo($branch, only: ['code', 'name'])
			]);

		} else {

			return $this->error("You're not authorized to delete this branch");

		}

		return $this->success("Branch Successfuly Deleted", $this->getShowData($branch));       
    }
}