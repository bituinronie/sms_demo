<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building,
    App\Models\Room\Room,
    App\Models\ActivityLog\ActivityLog;

class ArchiveBuildingRepository extends BaseRepository
{
    public function execute($branchCode, $buildingCode){

        $building = Building::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($buildingCode))->firstOrFail();


        // *** Archive only if user and building branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $building->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // *** Don't archive if used by other module
            $room = Room::where('building_id', '=', $building->id)->get();

            if ($room->isEmpty()) {

                $building->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "FACILITY",
                    "message" => "ARCHIVED A BUILDING",
                    "causeTo" => $this->activityCauseTo($building, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
                ]);

            } elseif ($room->isNotEmpty()) {

                return $this->error("Can't archive because this building is currently in use");
            }
            

        } else {

            return $this->error("You're not authorized to archive this building");
        }

        return $this->success("Building Successfuly Archived", 
            $this->getShowData(
                $building, 
                getForeign: [
                    'branch'  => ['code', 'name']
                ]
            )
        );
	}
}