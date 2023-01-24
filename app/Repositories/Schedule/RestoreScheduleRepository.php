<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

use App\Models\Schedule\Schedule,
    App\Models\ActivityLog\ActivityLog;

class RestoreScheduleRepository extends BaseRepository
{
    public function execute($branchCode, $scheduleCode){

        $schedule = Schedule::onlyTrashed()->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($scheduleCode))->firstOrFail();

        // *** Archive only if user and schedule branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $schedule->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $schedule->restore();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "RESTORE",
                "module"  => "COLLEGE",
                "message" => "RESTORED A SCHEDULE",
                "causeTo" => $this->activityCauseTo($schedule, only: ['code'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to restore this schedule");
        }

        return $this->success("Schedule Successfuly Restored",
            $this->getShowData(
                $schedule,
                getForeign: [
                    'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                    'section'  => ['code', 'type', 'year_level', 'semester', 'class_size'],
                    'subject'  => ['code', 'name', 'type'],
                    'branch'   => ['code', 'name']
                ]
            )
        );
	}
}