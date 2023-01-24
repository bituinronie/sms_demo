<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section,
    App\Models\ActivityLog\ActivityLog;

class ArchiveSectionRepository extends BaseRepository
{
    public function execute($branchCode, $sectionCode){

        $section = Section::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($sectionCode))->firstOrFail();

        // *** Archive only if user and section branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $section->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // // *** Don't archive if used by other module
            // $admission = ApplicantAdmission::where('program_id', '=', $program->id)->get();

            // if ($admission->isEmpty()) {

                $section->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "COLLEGE",
                    "message" => "ARCHIVED A SECTION",
                    "causeTo" => $this->activityCauseTo($section, only: ['code'], getForeign: ['branch'=>['code', 'name']])
                ]);

            // } elseif ($admission->isNotEmpty()) {

            //     return $this->error("Can't archive because this program is currently in use");
            // }

        } else {

            return $this->error("You're not authorized to archive this section");

        }

        return $this->success("Section Successfuly Archived",
            $this->getShowData(
                $section, 
                getForeign: [
                    'branch'     => ['code','name'],
                    'department' => ['code', 'name']
                ]
            )
        ); 
	}
}