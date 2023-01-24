<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand,
    App\Models\Admission\ApplicantAdmission,
    App\Models\ActivityLog\ActivityLog;

class ArchiveStrandRepository extends BaseRepository
{
    public function execute($branchCode, $strandCode){

        $strand = Strand::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($strandCode))->firstOrFail();

        // *** Archive only if user and strand branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $strand->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // *** Don't archive if used by other module
            $admission = ApplicantAdmission::where('strand_id', '=', $strand->id)->get();

            if ($admission->isEmpty()) {

                $strand->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "BASIC EDUCATION",
                    "message" => "ARCHIVED A STRAND",
                    "causeTo" => $this->activityCauseTo($strand, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
                ]);

            } elseif ($admission->isNotEmpty()) {

                return $this->error("Can't archive because this strand is currently in use");
            }

            

        } else {

            return $this->error("You're not authorized to archive this strand");

        }

        return $this->success("Strand Successfuly Archived",
            $this->getShowData(
                $strand, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
	}
}