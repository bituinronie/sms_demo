<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

use App\Models\Schedule\Schedule,
    App\Models\ActivityLog\ActivityLog;

class DeleteScheduleRepository extends BaseRepository
{
    public function execute($branchCode, $scheduleCode) {

        $schedule = Schedule::onlyTrashed()->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($scheduleCode))->firstOrFail();
        
        // *** Delete only if user and program branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $schedule->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $schedule->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "COLLEGE",
                "message" => "DELETED A SCHEDULE",
                "causeTo" => $this->activityCauseTo($schedule, only: ['code'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this schedule");
        }

        return $this->success("Schedule Successfuly Deleted",
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