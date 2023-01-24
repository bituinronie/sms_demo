<?php

namespace App\Repositories\Curriculum;

use App\Repositories\BaseRepository;

use App\Models\Curriculum\Curriculum,
    App\Models\ActivityLog\ActivityLog;

class ArchiveCurriculumRepository extends BaseRepository
{
    public function execute($branchCode, $curriculumCode){

        $curriculum = Curriculum::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($curriculumCode))->firstOrFail();

        // *** Archive only if user and curriculum branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $curriculum->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // !!! ALERT: uncomment if used by other module
            // *** Don't archive if used by other module
            // $admission = ApplicantAdmission::where('program_id', '=', $program->id)->get();

            // if ($admission->isEmpty()) {

                $curriculum->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "COLLEGE",
                    "message" => "ARCHIVED A CURRICULUM",
                    "causeTo" => $this->activityCauseTo($curriculum, only: ['code', 'type'], getForeign: ['branch'=>['code', 'name']])
                ]);

            // } elseif ($admission->isNotEmpty()) {

            // 	return $this->error("Can't archive because this program is currently in use");
            // }

        } else {

            return $this->error("You're not authorized to archive this curriculum");
        }

        return $this->success("Curriculum Successfuly Archived",
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