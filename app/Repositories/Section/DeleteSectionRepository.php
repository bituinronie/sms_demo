<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section,
    App\Models\ActivityLog\ActivityLog;

class DeleteSectionRepository extends BaseRepository
{
    public function execute($branchCode, $sectionCode) {
            
        $section = Section::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($sectionCode))->firstOrFail();
        
        // *** Delete only if user and section branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $section->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $section->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "COLLEGE",
                "message" => "DELETED A SECTION",
                "causeTo" => $this->activityCauseTo($section, only: ['code'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this section");
        }

        return $this->success("Section Successfuly Deleted",
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