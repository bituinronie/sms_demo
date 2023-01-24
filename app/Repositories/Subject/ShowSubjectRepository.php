<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject;

class ShowSubjectRepository extends BaseRepository
{
    public function execute($branchCode, $subjectCode) {

        $subject = Subject::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($subjectCode))->firstOrFail();

        // *** Show only if user and subject branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $subject->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Subject Found", 
                $this->getShowData(
                    $subject,
                    getForeign: [
                        'laboratory' => ['code', 'name'],
                        'department' => ['code', 'name'],
                        'branch'     => ['code', 'name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this subject");

        }
    }
}