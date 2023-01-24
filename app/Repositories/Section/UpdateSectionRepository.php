<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section,
    App\Models\ActivityLog\ActivityLog;

class UpdateSectionRepository extends BaseRepository
{
    public function execute($request, $branchCode, $sectionCode) {
            
        $section = Section::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($sectionCode))->firstOrFail();

        // *** Initialized old data (used for: activity logs)
        $originalSection = Section::find($section->id); 

        // *** Update only if user, section branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $section->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $section->update([
                "code"          => strtoupper($request->code),
                "type"          => strtoupper($request->type),
                "year_level"    => strtoupper($request->yearLevel),
                "semester"      => strtoupper($request->semester),
                "class_size"    => strtoupper($request->classSize),
                "department_id" => $this->getDepartmentId($request->department),
                "branch_id"     => $this->getBranchId($request->branch)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedSection = Section::find($section->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "COLLEGE",
                "message" => "UPDATED A SECTION",
                "causeTo" => $this->activityCauseTo($updatedSection, only: ['code'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalSection,
                    $updatedSection,
                    getForeign: [
                        'employee'   => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                        'department' => ['code', 'name'],
                        'branch'     => ['code','name']
                    ],
                    ignored   : ['employee_id', 'department_id', 'branch_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this section");

        }


        return $this->success("Section Successfuly Updated",
            $this->getShowData(
                $updatedSection, 
                getForeign: [
                    'branch'     => ['code','name'],
                    'department' => ['code', 'name']
                ]
            )
        );
    }
}