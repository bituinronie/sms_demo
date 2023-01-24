<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building,
    App\Models\Room\Room,
    App\Models\ActivityLog\ActivityLog;

class UpdateBuildingRepository extends BaseRepository
{
    public function execute($request, $branchCode, $buildingCode) {

        $building = Building::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($buildingCode))->firstOrFail();

        // *** Initialized old data (used for: activity logs)
        $originalBuilding = Building::find($building->id);
        
        // *** Update only if user, building branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $building->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            // *** Update room branch if building branch is change (Building connected to room must be same branch)
            if ($branchCode != $request->branch) {
                $room = Room::where('building_id', '=', $building->id)->get();

                foreach ($room as $key) {
                    $key->update([
                        "branch_id" => $this->getBranchId($request->branch)
                    ]);
                }
            }

            $building->update([
                "code"      => strtoupper($request->code),
                "name"      => strtoupper($request->name),
                "branch_id" => $this->getBranchId($request->branch)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedBuilding = Building::find($building->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "FACILITY",
                "message" => "UPDATED A BUILDING",
                "causeTo" => $this->activityCauseTo($updatedBuilding, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalBuilding, 
                    $updatedBuilding, 
                    getForeign: ['branch'=>['code', 'name']],
                    ignored   : ['branch_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this building");

        }

        return $this->success("Building Successfuly Updated",
            $this->getShowData(
                $updatedBuilding, 
                getForeign: [
                    'branch'  => ['code', 'name']
                ]
            )
        );
    }
}