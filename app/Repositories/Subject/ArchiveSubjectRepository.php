<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject,
    App\Models\ActivityLog\ActivityLog;

class ArchiveSubjectRepository extends BaseRepository
{
    public function execute($branchCode, $subjectCode){

        $subject = Subject::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($subjectCode))->firstOrFail();

        // *** Archive only if user and subject branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $subject->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // !!! ALERT: uncomment if used by other module
            // *** Don't archive if used by other module
            // $admission = ApplicantAdmission::where('program_id', '=', $program->id)->get();

            // if ($admission->isEmpty()) {

                $subject->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "COLLEGE",
                    "message" => "ARCHIVED A SUBJECT",
                    "causeTo" => $this->activityCauseTo($subject, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
                ]);

            // } elseif ($admission->isNotEmpty()) {

            // 	return $this->error("Can't archive because this program is currently in use");
            // }

        } else {

            return $this->error("You're not authorized to archive this subject");
        }

        return $this->success("Subject Successfuly Archived",
            $this->getShowData(
                $subject,
                getForeign: [
                    'laboratory' => ['code', 'name'],
                    'department' => ['code', 'name'],
                    'branch'     => ['code', 'name']
                ]
            )
        );
	}
}