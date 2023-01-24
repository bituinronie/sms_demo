<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

use App\Models\Schedule\Schedule,
    App\Models\ActivityLog\ActivityLog;

class ArchiveScheduleRepository extends BaseRepository
{
    public function execute($branchCode, $scheduleCode){

        $schedule = Schedule::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($scheduleCode))->firstOrFail();

        // *** Archive only if user and schedule branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $schedule->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // !!! ALERT: uncomment if used by other module
            // *** Don't archive if used by other module
            // $admission = ApplicantAdmission::where('program_id', '=', $program->id)->get();

            // if ($admission->isEmpty()) {

                $schedule->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "COLLEGE",
                    "message" => "ARCHIVED A SCHEDULE",
                    "causeTo" => $this->activityCauseTo($schedule, only: ['code'], getForeign: ['branch'=>['code', 'name']])
                ]);

            // } elseif ($admission->isNotEmpty()) {

            // 	return $this->error("Can't archive because this program is currently in use");
            // }

        } else {

            return $this->error("You're not authorized to archive this schedule");
        }

        return $this->success("Schedule Successfuly Archived",
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