<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand,
    App\Models\ActivityLog\ActivityLog;

class UpdateStrandRepository extends BaseRepository
{
    public function execute($request, $branchCode, $strandCode) {
            
        $strand = Strand::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($strandCode))->firstOrFail(); 

        // *** Initialized old data (used for: activity logs)
        $originalStrand= Strand::find($strand->id);

        // *** Update only if user, strand branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $strand->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $strand->update([
                "code"      => strtoupper($request->code),
                "name"      => strtoupper($request->name),
                "track"     => strtoupper($request->track),
                "branch_id" => $this->getBranchId($request->branch)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedStrand = Strand::find($strand->id); 

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "BASIC EDUCATION",
                "message" => "UPDATED A STRAND",
                "causeTo" => $this->activityCauseTo($strand, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalStrand,
                    $updatedStrand,
                    getForeign: ['branch'=>['code','name']],
                    ignored   : ['branch_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this strand");

        }

        return $this->success("Strand Successfuly Updated",
            $this->getShowData(
                $updatedStrand, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
    }
}