<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch,
    App\Models\ActivityLog\ActivityLog;

class UpdateBranchRepository extends BaseRepository
{
    public function execute($request, $branchCode) {

        // *** Update only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $branch = Branch::where('code', '=', $branchCode)->firstOrFail();
            
            // *** Initialized old data (used for: activity logs)
            $originalBranch = Branch::find($branch->id);

            $branch->update([
                "name" => strtoupper($request->name),
                "type" => strtoupper($request->type) ?: $branch->type
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedBranch = Branch::find($branch->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "SYSTEM",
                "message" => "UPDATED A BRANCH",
                "causeTo" => $this->activityCauseTo($updatedBranch, only: ['code', 'name']),
                "data"    => $this->activityChangedOnly($originalBranch, $updatedBranch)
            ]);


        } else {

            return $this->error("You're not authorized to update this branch");

        }
        
        return $this->success("Branch Successfuly Updated", $this->getShowData($updatedBranch));
    }
}