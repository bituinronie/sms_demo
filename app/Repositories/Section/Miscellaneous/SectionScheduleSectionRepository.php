<?php

namespace App\Repositories\Section\Miscellaneous;

use App\Repositories\BaseRepository;

use Arr, Carbon\Carbon;

use App\Models\Section\Section;

class SectionScheduleSectionRepository extends BaseRepository
{
    public function execute($branchCode, $sectionCode) {

        $section = Section::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($sectionCode))->firstOrFail();

        // *** Show only if user and section branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $section->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            foreach ($section->schedule as $scheduleKey => $schedule) {

                foreach ($schedule->scheduleDate as $scheduleDateKey => $date) {

                    $scheduleDate[$scheduleDateKey] = [
                            "room"      => $date->room->code,
                            "day"       => $date->day,
                            "timeStart" => $date->time_start,
                            "timeEnd"   => Carbon::parse($date->time_end)->addMinute()->toTimeString()
                    ];
                }

                $sectionSchedule[$scheduleKey] = [
                    "scheduleCode" => $schedule->code,
                    "subjectCode"  => $schedule->subject->code,
                    "branch"       => [
                        "code" => $schedule->branch->code,
                        "name" => $schedule->branch->name
                    ],
                    "employee"     => $schedule->employee ? [ 
                        "employeeNumber" => $schedule->employee->employee_number,
                        "lastName"       => $schedule->employee->last_name,
                        "firstName"      => $schedule->employee->first_name,
                        "middleName"     => $schedule->employee->middle_name
                        ]: null,
                    "subjectSchedule" => $scheduleDate ?? null
                ];
            }

            return $sectionSchedule ?? null ? $this->success("Section Schedule Found", $sectionSchedule) : $this->error("Section Schedule Empty", 404);

        } else {

            return $this->error("You're not authorized to view this section");
        }
    }
}