<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section,
    App\Models\ActivityLog\ActivityLog;

class RestoreSectionRepository extends BaseRepository
{
    public function execute($branchCode, $sectionCode){
			
		$section = Section::onlyTrashed()
		->where('branch_id', '=', $this->getBranchId($branchCode))
		->where('code', '=', strtoupper($sectionCode))->firstOrFail();

		// *** Restore only if user and section branch is same or if user is main branch
		if (
			$this->user()->employee->branch->id == $section->branch->id ||
			$this->user()->employee->branch->type == "MAIN"
		) {

			$section->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "COLLEGE",
				"message" => "RESTORED A SECTION",
				"causeTo" => $this->activityCauseTo($section, only: ['code'], getForeign: ['branch'=>['code', 'name']])
			]);

		} else {

			return $this->error("You're not authorized to restore this section");
		}

		return $this->success("Section Successfuly Restored",
			$this->getShowData(
				$section, 
                getForeign: [
                    'branch'     => ['code','name'],
                    'department' => ['code', 'name']
                ]
			)
		);
	}
}