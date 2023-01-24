<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

use Carbon\Carbon;

use App\Models\Schedule\Schedule,
    App\Models\Room\Room;

trait Scheduling
{
    protected function hasConflict($branchId, $schedule){
        
        $databaseData = Schedule::join(
            'schedule_dates', 
            'schedule_dates.schedule_id', '=', 
            'schedules.id'
        )->where('branch_id', '=', $branchId)->get();

        foreach ($schedule as $subjects) {

            foreach ($subjects['subjectSchedule'] as $subjectSchedule) {

                $time_start = Carbon::parse($subjectSchedule['updated']['timeStart'] ?? $subjectSchedule['timeStart'])->toTimeString();
                $time_end   = Carbon::parse($subjectSchedule['updated']['timeEnd'] ?? $subjectSchedule['timeEnd'])->subMinute()->toTimeString();

                foreach ($databaseData as $db) {

                    if ($this->getRoomId($subjectSchedule['updated']['room'] ?? $subjectSchedule['room']) === $db->room_id) {

                        if (strtoupper($subjectSchedule['updated']['day'] ?? $subjectSchedule['day']) === $db->day) {

                            if (
                                (
                                    ($time_start >= $db->time_start && $time_start <= $db->time_end)
                                    ||
                                    ($time_end >= $db->time_start && $time_end <= $db->time_end)
                                )
                                ||
                                (
                                    ($db->time_start >= $time_start && $db->time_start <= $time_end)
                                    ||
                                    ($db->time_end >= $time_start && $db->time_end <= $time_end)
                                )
                            ) {

                                    $conflictData[] = [
                                            "classCode"   => $db->code,
                                            "subjectCode" => $db->subject->code,
                                            "sectionCode" => $db->section->code,
                                            "roomCode"    => Room::find($db->room_id)->code,
                                            "day"         => $db->day,
                                            "timeStart"   => $db->time_start,
                                            "timeEnd"     => Carbon::parse($db->time_end)->addMinute()->toTimeString(),
                                            "employee"    => $db->employee_id ?
                                            [
                                                "employeeNumber" => $db->employee->employee_number,
                                                "lastName"       => $db->employee->last_name,
                                                'firstName'      => $db->employee->first_name,
                                                'middleName'     => $db->employee->middle_name
                                            ]: ""
                                    ];
                            }
                        }
                    }
                }
            }
        }

        return $conflictData ?? null;
    }
}