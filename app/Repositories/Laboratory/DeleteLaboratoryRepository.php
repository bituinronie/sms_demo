<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory,
    App\Models\ActivityLog\ActivityLog;

class DeleteLaboratoryRepository extends BaseRepository
{
    public function execute($branchCode, $laboratoryCode) {
            
        $laboratory = Laboratory::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($laboratoryCode))->firstOrFail();
        
        // *** Delete only if user and laboratory branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $laboratory->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $laboratory->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "FACILITY",
                "message" => "DELETED A LABORATORY",
                "causeTo" => $this->activityCauseTo($laboratory, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this laboratory");
        }

        return $this->success("Laboratory Successfuly Deleted", 
            $this->getShowData(
                $laboratory, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
    }
}