<?php

namespace App\Repositories\Curriculum;

use App\Repositories\BaseRepository;

use App\Models\Curriculum\Curriculum,
    App\Models\ActivityLog\ActivityLog;

class RestoreCurriculumRepository extends BaseRepository
{
    public function execute($branchCode, $curriculumCode){

        $curriculum = Curriculum::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($curriculumCode))->firstOrFail();

        // *** Archive only if user and curriculum branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $curriculum->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $curriculum->restore();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "RESTORE",
                "module"  => "COLLEGE",
                "message" => "RESTORED A CURRICULUM",
                "causeTo" => $this->activityCauseTo($curriculum, only: ['code', 'type'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to restore this curriculum");
        }

        return $this->success("Curriculum Successfuly Restored",
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
}