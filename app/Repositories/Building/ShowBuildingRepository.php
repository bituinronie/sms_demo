<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building;

class ShowBuildingRepository extends BaseRepository
{
    public function execute($branchCode, $buildingCode){

        $building = Building::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($buildingCode))->firstOrFail();

        // *** Show only if user and building branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $building->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Building Found", 
                $this->getShowData(
                    $building, 
                    getForeign: [
                        'branch'  => ['code', 'name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this building");
        }
    }
}