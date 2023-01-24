<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

use Arr, Carbon\Carbon;

use App\Models\Schedule\Schedule,
    App\Models\Schedule\ScheduleDate,
    App\Models\Section\Section,
    App\Models\ActivityLog\ActivityLog;

class CreateScheduleRepository extends BaseRepository
{
    public function execute($request) {

        // *** Initialized section: Schedule and section must be same branch (used for: branch and section)
        $section = Section::where('code', '=', strtoupper($request->section))->firstOrFail();

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $section->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            if(!Arr::accessible($conflict=$this->hasConflict($section->branch->id, $request->schedule))){

                foreach ($request->schedule as $subject) {

                    $this->createSchedule(
                        $section->branch->id,
                        $this->getSectionId($request->section),
                        $this->getSubjectId($subject['subject']),
                        $subject['employee'] ? $this->getEmployeeId($subject['employee']) : null,
                        $subject['subjectSchedule']
                    );
                }

            }else{

                return response()->json([
                    'message' => "Conflict Found",
                    'results' => $conflict,
                    'code'    => 409,
                    'error'   => true
                ], 409);
            }

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "COLLEGE",
                "message" => "CREATED A SCHEDULE",
                "data"    => 
                [
                    "new" => [
                        "SECTION" => $section->code,
                    ]
                ]
            ]);
            
        } else {

            return $this->error("You're not authorized to create a schedule");
        }

        return $this->success("Schedule Successfuly Created", ['section' => strtoupper($request->section)]);

    }


    private function createSchedule($branchId, $sectionId, $subjectId, $employeeId, $subjectSchedule){

        $schedule = Schedule::create([
            "code"        => $this->classCode(),
            "branch_id"   => $branchId,
            "section_id"  => $sectionId,
            "subject_id"  => $subjectId,
            "employee_id" => $employeeId ?? null,
        ]);

        foreach ($subjectSchedule as $scheduleDate) {
                    
            ScheduleDate::create([
                "schedule_id" => $schedule->id,
                "room_id"     => $this->getRoomId($scheduleDate['room']),
                "day"         => strtoupper($scheduleDate['day']),
                "time_start"  => $scheduleDate['timeStart'],
                "time_end"    => Carbon::parse($scheduleDate['timeEnd'])->subMinute()
            ]);
        }
    }
}