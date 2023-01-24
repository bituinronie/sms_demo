<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand,
	App\Models\ActivityLog\ActivityLog;

class RestoreStrandRepository extends BaseRepository
{
    public function execute($branchCode, $strandCode){
			
		$strand = Strand::onlyTrashed()
		->where('branch_id', '=', $this->getBranchId($branchCode))
		->where('code', '=', strtoupper($strandCode))->firstOrFail();

		// *** Restore only if user and strand branch is same or if user is main branch
		if (
			$this->user()->employee->branch->id == $strand->branch->id ||
			$this->user()->employee->branch->type == "MAIN"
		) {

			$strand->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "BASIC EDUCATION",
				"message" => "RESTORED A STRAND",
				"causeTo" => $this->activityCauseTo($strand, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
			]);

		} else {

			return $this->error("You're not authorized to restore this strand");

		}

		return $this->success("Strand Successfuly Restored",
			$this->getShowData(
				$strand, 
				getForeign: [
					'branch' => ['code','name']
				]
			)
		);
	}
}