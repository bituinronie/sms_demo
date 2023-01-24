<?php

namespace App\Repositories\Curriculum;

use App\Repositories\BaseRepository;

use Arr, Str;

use App\Models\Curriculum\Curriculum,
    App\Models\Curriculum\CurriculumSubject;

class ShowCurriculumRepository extends BaseRepository
{
    public function execute($branchCode, $curriculumCode) {

        $curriculum = Curriculum::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($curriculumCode))->firstOrFail();

        $curriculumSubject = CurriculumSubject::where('curriculum_id', '=', $curriculum->id)->get();

        // *** Show only if user and subject branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $curriculum->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            foreach ($curriculumSubject as $subject) {

                $curriculumAllSubject['curriculumSubject'][] = [
                    'code'           => $subject->subject->code,
                    'name'           => $subject->subject->name,
                    'lectureUnit'    => $subject->subject->lecture_unit,
                    'laboratoryUnit' => $subject->subject->laboratory_unit,
                    'prerequisite'   => $subject->prerequisite->code ?? '',
                    'corequisite'    => $subject->corequisite->code ?? '',
                    'alias'          => $subject->alias,
                    'yearLevel'      => $subject->year_level,
                    'semester'       => $subject->semester
                ];
                
            }

            return $this->success("Curriculum Found", Arr::collapse([
                $this->getShowData(
                    $curriculum,
                    getForeign: [
                        'branch'     => ['code', 'name'],
                        'department' => ['code', 'name'],
                        'program'    => ['code', 'name', 'duration'],
                    ]
                ),
                $curriculumAllSubject
            ]));

        } else {

            return $this->error("You're not authorized to view this curriculum");

        }
    }
}