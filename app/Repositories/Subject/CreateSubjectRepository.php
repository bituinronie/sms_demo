<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject,
    App\Models\ActivityLog\ActivityLog;

class CreateSubjectRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $subject = Subject::create([
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

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "COLLEGE",
                "message" => "CREATED A SUBJECT",
                "data"    => 
                [
                    "new" => [
                        "CODE"            => $subject->code,
                        "NAME"            => $subject->name,
                        "TYPE"            => $subject->type,
                        "LECTURE UNIT"    => $subject->lecture_unit,
                        "LECTURE HOUR"    => $subject->lecture_hour,
                        "LABORATORY UNIT" => $subject->laboratory_unit,
                        "LABORATORY HOUR" => $subject->laboratory_hour,
                        "BRANCH"          => $subject->branch->name,
                        "LABORATORY"      => $subject->laboratory->name ?? null,
                        "DEPARTMENT"      => $subject->department->name,
                    ]
                ]
            ]);
            
        } else {

            return $this->error("You're not authorized to create a subject");
        }

        return $this->success("Subject Successfuly Created",
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