<?php

namespace App\Repositories\Curriculum;

use App\Repositories\BaseRepository;

use Arr, Str;

use App\Models\Curriculum\Curriculum,
    App\Models\Curriculum\CurriculumSubject,
    App\Models\ActivityLog\ActivityLog;

class CreateCurriculumRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $curriculum = Curriculum::create([
                "code"          => strtoupper($request->code),
                "type"          => $request->type,
                "branch_id"     => $this->getBranchId($request->branch),
                "department_id" => $this->getDepartmentId($request->department),
                "program_id"    => $this->getProgramId($request->program),
            ]);

            if ($curriculum->type === 'COLLEGE') {

                foreach($request->curriculumSubject as $subject){

                    $this->createCurriculumSubject($curriculum->id, $subject);
                }

            } elseif ($curriculum->type === 'BASIC EDUCATION') {

                return $this->error("Basic education curriculum is not yet available");
            }

            

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "COLLEGE",
                "message" => "CREATED A CURRICULUM",
                "data"    => 
                [
                    "new" => [
                        "CODE"       => $curriculum->code,
                        "TYPE"       => $curriculum->type,
                        "BRANCH"     => $curriculum->branch->name,
                        "DEPARTMENT" => $curriculum->department->name,
                        "PROGRAM"    => $curriculum->program->name
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a curriculum");

        }

        return $this->success("Curriculum Successfuly Created",
            $this->getShowData(
                $curriculum,
                getForeign: [
                    'branch'     => ['code', 'name'],
                    'department' => ['code', 'name'],
                    'program'    => ['code', 'name'],
                ]
            )
        );
    }


    private function createCurriculumSubject($curriculumId, $subject){

        CurriculumSubject::create([
            "curriculum_id"           => $curriculumId,
            "subject_id"              => $this->getSubjectId($subject['code']),
            "prerequisite_subject_id" => $subject['prerequisite'] ? $this->getSubjectId($subject['prerequisite']) : null,
            "corequisite_subject_id"  => $subject['corequisite'] ? $this->getSubjectId($subject['corequisite']) : null,
            "alias"                   => strtoupper($subject['alias']),
            "year_level"              => strtoupper($subject['yearLevel']),
            "semester"                => strtoupper($subject['semester'])
        ]);
    }
}