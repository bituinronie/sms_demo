<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building,
    App\Models\ActivityLog\ActivityLog;

class DeleteBuildingRepository extends BaseRepository
{
    public function execute($branchCode, $buildingCode) {
            
        $building = Building::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($buildingCode))->firstOrFail();
        
        // *** Delete only if user and building branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $building->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // *** The permanent delete in room is already cascade in db (No need to write code)

            $building->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "FACILITY",
                "message" => "DELETED A BUILDING",
                "causeTo" => $this->activityCauseTo($building, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this building");

        }

        return $this->success("Building Successfuly Deleted",
            $this->getShowData(
                $building, 
                getForeign: [
                    'branch'  => ['code', 'name']
                ]
            )
        );
    }
}