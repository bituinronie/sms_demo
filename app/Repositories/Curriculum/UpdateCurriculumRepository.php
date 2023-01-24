<?php

namespace App\Repositories\Curriculum;

use App\Repositories\BaseRepository;

Use Arr, Str;

use App\Models\Curriculum\Curriculum,
    App\Models\Curriculum\CurriculumSubject,
    App\Models\ActivityLog\ActivityLog;

class UpdateCurriculumRepository extends BaseRepository
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


            if ($curriculum->type === 'COLLEGE') {

                foreach($request->curriculumSubject as $type => $data){

                    switch ($type) {
                        case 'added':
                            
                            foreach ($data as $subject) {

                                $this->addedCurriculumSubject($curriculum->id, $subject);
                            }
                            break;
            
                        case 'updated':
                        
                            foreach ($data as $subject) {

                                $this->updatedCurriculumSubject($curriculum->id, $subject);
                            }
                            break;
            
                        case 'deleted':
            
                            foreach ($data as $subject) {

                                $this->deletedCurriculumSubject($curriculum->id, $subject);
                            }
                            break;
                    }

                    
                }

            } elseif ($curriculum->type === 'BASIC EDUCATION') {

                return $this->error("Basic education curriculum is not yet available");
            }

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedCurriculum = Curriculum::find($curriculum->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "COLLEGE",
                "message" => "UPDATED A CURRICULUM",
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


    private function addedCurriculumSubject($curriculumId, $subject){

        $existingSubject = CurriculumSubject::
            where('curriculum_id', '=', $curriculumId)->
            where('subject_id', '=', $this->getSubjectId($subject['code']))->
            where('year_level', '=', strtoupper($subject['yearLevel']))->
            where('semester', '=',  strtoupper($subject['semester']))->first();

        if ($existingSubject === null) {

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



    private function updatedCurriculumSubject($curriculumId, $subject){

        CurriculumSubject::where('curriculum_id', '=', $curriculumId)->
        where('subject_id', '=', $this->getSubjectId($subject['code']))->
        update([
                "subject_id"              => $this->getSubjectId($subject['code']),
                "prerequisite_subject_id" => $subject['prerequisite'] ? $this->getSubjectId($subject['prerequisite']) : null,
                "corequisite_subject_id"  => $subject['corequisite'] ? $this->getSubjectId($subject['corequisite']) : null,
                "alias"                   => strtoupper($subject['alias']),
                "year_level"              => strtoupper($subject['yearLevel']),
                "semester"                => strtoupper($subject['semester'])
        ]);

    }



    private function deletedCurriculumSubject($curriculumId, $subject){

        CurriculumSubject::where('curriculum_id', '=', $curriculumId)->where('subject_id', '=', $this->getSubjectId($subject['code']))->delete();
    }
}