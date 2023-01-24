<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

use Arr, Str, Carbon\Carbon;

use App\Models\Schedule\Schedule,
    App\Models\Schedule\ScheduleDate;

class ShowScheduleRepository extends BaseRepository
{
    public function execute($branchCode, $scheduleCode) {

        $schedule = Schedule::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($scheduleCode))->firstOrFail();

        $scheduleDate = ScheduleDate::where('schedule_id', '=', $schedule->id)->get();

        // *** Show only if user and schedule branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $schedule->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            foreach ($scheduleDate as $date) {

                $scheduleAllDate['subjectSchedule'][] = [
                    "room"      => $date->room->code,
                    "day"       => $date->day,
                    "timeStart" => $date->time_start,
                    "timeEnd"   => Carbon::parse($date->time_end)->addMinute()->toTimeString()
                ];
            }

            return $this->success("Schedule Found", Arr::collapse([
                $this->getShowData(
                    $schedule,
                    getForeign: [
                        'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                        'section'  => ['code', 'type', 'year_level', 'semester', 'class_size'],
                        'subject'  => ['code', 'name', 'type'],
                        'branch'   => ['code', 'name']
                    ]
                ),
                $scheduleAllDate
            ]));

        } else {

            return $this->error("You're not authorized to view this schedule");
        }
    }
}