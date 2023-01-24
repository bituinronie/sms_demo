<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building,
    App\Models\Room\Room,
	App\Models\ActivityLog\ActivityLog;

class RestoreBuildingRepository extends BaseRepository
{
    public function execute($branchCode, $buildingCode){

		$building = Building::onlyTrashed()
		->where('branch_id', '=', $this->getBranchId($branchCode))
		->where('code', '=', strtoupper($buildingCode))->firstOrFail();

		// *** Restore only if user and building branch is same or if user is main branch
		if (
			$this->user()->employee->branch->id == $building->branch->id ||
			$this->user()->employee->branch->type == "MAIN"
		) {

			$room = Room::onlyTrashed()->where('building_id', '=', $building->id)->get();

			foreach ($room as $key) {
				$key->restore();
			}

			$building->restore();

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "RESTORE",
				"module"  => "FACILITY",
				"message" => "RESTORED A BUILDING",
				"causeTo" => $this->activityCauseTo($building, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
			]);

		} else {

			return $this->error("You're not authorized to restore this building");
		}


		return $this->success("Building Successfuly Restored",
			$this->getShowData(
				$building, 
				getForeign: [
					'branch'  => ['code', 'name']
				]
			)
		);
	}
}