<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject,
    App\Models\ActivityLog\ActivityLog;

class DeleteSubjectRepository extends BaseRepository
{
    public function execute($branchCode, $subjectCode) {
            
        $subject = Subject::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($subjectCode))->firstOrFail();
        
        // *** Delete only if user and subject branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $subject->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $subject->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "COLLEGE",
                "message" => "DELETED A SUBJECT",
                "causeTo" => $this->activityCauseTo($subject, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this subject");
        }

        return $this->success("Subject Successfuly Deleted",
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