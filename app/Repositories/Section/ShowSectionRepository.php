<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section;

class ShowSectionRepository extends BaseRepository
{
    public function execute($branchCode, $sectionCode) {

        $section = Section::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($sectionCode))->firstOrFail();

        // *** Show only if user and section branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $section->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Section Found", 
                $this->getShowData(
                    $section, 
                    getForeign: [
                        'branch'     => ['code','name'],
                        'department' => ['code', 'name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this section");
        }
    }
}