<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand,
    App\Models\ActivityLog\ActivityLog;

class DeleteStrandRepository extends BaseRepository
{
    public function execute($branchCode, $strandCode) {

        $strand = Strand::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($strandCode))->firstOrFail();

        // *** Delete only if user and strand branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $strand->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $strand->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "BASIC EDUCATION",
                "message" => "DELETED A STRAND",
                "causeTo" => $this->activityCauseTo($strand, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this strand");
        }

        return $this->success("Strand Successfuly Deleted",
            $this->getShowData(
                $strand, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
    }
}