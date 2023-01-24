<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building,
    App\Models\ActivityLog\ActivityLog;

class CreateBuildingRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $building = Building::create([
                "code"      => strtoupper($request->code),
                "name"      => strtoupper($request->name),
                "branch_id" => $this->getBranchId($request->branch)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "FACILITY",
                "message" => "CREATED A BUILDING",
                "data"    => 
                [
                    "new" => [
                        "CODE"   => $building->code,
                        "NAME"   => $building->name,
                        "BRANCH" => $building->branch->name
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a building");

        }

        return $this->success("Building Successfuly Created",
            $this->getShowData(
                $building, 
                getForeign: [
                    'branch'  => ['code', 'name']
                ]
            )
        );
    }
}