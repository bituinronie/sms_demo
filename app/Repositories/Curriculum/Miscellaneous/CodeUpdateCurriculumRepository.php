<?php

namespace App\Repositories\Curriculum\Miscellaneous;

use App\Repositories\BaseRepository;

Use Arr, Str;

use App\Models\Curriculum\Curriculum,
    App\Models\ActivityLog\ActivityLog;

class CodeUpdateCurriculumRepository extends BaseRepository
{
    public function execute($request, $branchCode, $curriculumCode) {

        $curriculum = Curriculum::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($curriculumCode))->firstOrFail();

        // *** Initialized old data (used for: activity logs)
        $originalCurriculum = Curriculum::find($curriculum->id); 

        // *** Update only if user, curriculum branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $curriculum->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $curriculum->update([
                "code"          => strtoupper($request->code),
                "type"          => $request->type,
                "branch_id"     => $this->getBranchId($request->branch),
                "department_id" => $this->getDepartmentId($request->department),
                "program_id"    => $this->getProgramId($request->program),
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedCurriculum = Curriculum::find($curriculum->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "COLLEGE",
                "message" => "UPDATED A CURRICULUM BASIC INFO",
                "causeTo" => $this->activityCauseTo(
                    $updatedCurriculum, 
                    only: ['code', 'type'],
                    getForeign: [
                        'branch'     => ['code', 'name'],
                        'department' => ['code', 'name'],
                        'program'    => ['code', 'name']
                    ]),
                "data"    => $this->activityChangedOnly(
                    $originalCurriculum,
                    $updatedCurriculum,
                    getForeign: [
                        'branch'     => ['code', 'name'],
                        'department' => ['code', 'name'],
                        'program'    => ['code', 'name'],
                    ],
                    ignored   : ['branch_id', 'department_id', 'program_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this curriculum");
        }

        return $this->success("Curriculum Successfuly Updated",
            $this->getShowData(
                $updatedCurriculum,
                getForeign: [
                    'branch'     => ['code', 'name'],
                    'department' => ['code', 'name'],
                    'program'    => ['code', 'name'],
                ]
            )
        );
    }
}