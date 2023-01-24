<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section,
    App\Models\ActivityLog\ActivityLog;

class CreateSectionRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $section = Section::create([
                "code"          => strtoupper($request->code),
                "type"          => strtoupper($request->type),
                "year_level"    => strtoupper($request->yearLevel),
                "semester"      => strtoupper($request->semester),
                "class_size"    => strtoupper($request->classSize),
                "department_id" => $this->getDepartmentId($request->department),
                "branch_id"     => $this->getBranchId($request->branch)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "COLLEGE",
                "message" => "CREATED A SECTION",
                "data"    => 
                [
                    "new" => [
                        "CODE"       => $section->code,
                        "TYPE"       => $section->type,
                        "YEAR LEVEL" => $section->year_level,
                        "SEMESTER"   => $section->semester,
                        "CLASS SIZE" => $section->class_size,
                        "DEPARTMENT" => $section->department->name,
                        "BRANCH"     => $section->branch->name
                    ]
                ]
            ]);
            
        } else {

            return $this->error("You're not authorized to create a section");
        }

        return $this->success("Section Successfuly Created",
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