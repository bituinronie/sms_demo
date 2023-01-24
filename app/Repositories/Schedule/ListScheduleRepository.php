<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

use App\Models\Schedule\Schedule;

class ListScheduleRepository extends BaseRepository
{
    public function execute() {
            
        // *** Show all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $schedule = Schedule::onlyTrashed()->get();

        }
        // *** Show all data (current branch only)
        elseif($this->user()->employee->branch->type == "SUB"){

            $schedule = Schedule::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
            
        }
        else {

            return $this->error("You're not authorized to view all schedule");
            
        }

        return $this->success("List of All Archive Schedule",  $this->getIndexData(
            $schedule,
            getForeign: [
                'employee' => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                'section'  => ['code', 'type', 'year_level', 'semester', 'class_size'],
                'subject'  => ['code', 'name', 'type'],
                'branch'   => ['code', 'name']
            ],
            only: [
                'code'
            ])
        );
    }
}