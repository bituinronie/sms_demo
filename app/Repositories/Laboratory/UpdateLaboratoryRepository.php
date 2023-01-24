<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory,
    App\Models\ActivityLog\ActivityLog;

class UpdateLaboratoryRepository extends BaseRepository
{
    public function execute($request, $branchCode, $laboratoryCode) {

        $laboratory = Laboratory::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($laboratoryCode))->firstOrFail(); 

        // *** Initialized old data (used for: activity logs)
        $originalLaboratory = Laboratory::find($laboratory->id);
        
        // *** Update only if user, laboratory branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $laboratory->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $laboratory->update([
                "code"      => strtoupper($request->code),
                "name"      => strtoupper($request->name),
                "amount"    => $request->amount ?? 0,
                "branch_id" => $this->getBranchId($request->branch)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedLaboratory = Laboratory::find($laboratory->id); 

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "FACILITY",
                "message" => "UPDATED A LABORATORY",
                "causeTo" => $this->activityCauseTo($updatedLaboratory, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalLaboratory,
                    $updatedLaboratory,
                    getForeign: ['branch'=>['code','name']],
                    ignored   : ['branch_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this laboratory");
        }

        return $this->success("Laboratory Successfuly Updated",
            $this->getShowData(
                $updatedLaboratory, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
    }
}