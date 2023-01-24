<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject,
    App\Models\ActivityLog\ActivityLog;

class UpdateSubjectRepository extends BaseRepository
{
    public function execute($request, $branchCode, $subjectCode) {

        $subject = Subject::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($subjectCode))->firstOrFail();

        // *** Initialized old data (used for: activity logs)
        $originalSubject = Subject::find($subject->id); 

        // *** Update only if user, subject branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $subject->branch->id &&
                $this->user()->employee->branch->id == $this->getBranchId($request->branch)
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $subject->update([
                "code"            => strtoupper($request->code),
                "name"            => strtoupper($request->name),
                "type"            => strtoupper($request->type),
                "lecture_unit"    => $request->lectureUnit,
                "lecture_hour"    => $request->lectureHour,
                "laboratory_unit" => $request->laboratoryUnit ?? 0,
                "laboratory_hour" => $request->laboratoryHour ?? 0,
                "branch_id"       => $this->getBranchId($request->branch),
                "laboratory_id"   => $request->laboratory ? $this->getLaboratoryId($request->laboratory) : null,
                "department_id"   => $this->getDepartmentId($request->department)
            ]);

            // *** Initialized updated data (used for: activity logs & displaying data)
            $updatedSubject = Subject::find($subject->id);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "COLLEGE",
                "message" => "UPDATED A SUBJECT",
                "causeTo" => $this->activityCauseTo($updatedSubject, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalSubject,
                    $updatedSubject,
                    getForeign: [
                        'laboratory' => ['code', 'name'],
                        'department' => ['code', 'name'],
                        'branch'     => ['code', 'name']
                    ],
                    ignored   : ['branch_id', 'laboratory_id', 'department_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this subject");
        }

        return $this->success("Subject Successfuly Updated",
            $this->getShowData(
                $updatedSubject,
                getForeign: [
                    'laboratory' => ['code', 'name'],
                    'department' => ['code', 'name'],
                    'branch'     => ['code', 'name']
                ]
            )
        );
    }
}