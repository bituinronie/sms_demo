<?php

namespace App\Repositories\Schedule;

use App\Repositories\BaseRepository;

Use Arr, Carbon\Carbon;

use App\Models\Schedule\Schedule,
    App\Models\Schedule\ScheduleDate,
    App\Models\Section\Section;

class UpdateScheduleRepository extends BaseRepository
{
    public function execute($request, $branchCode, $scheduleCode) {

        $schedule = Schedule::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($scheduleCode))->firstOrFail();

        $section = Section::where('code', '=', strtoupper($request->section))->firstOrFail();
        

        // *** Update only if user, schedule branch and request branch is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $schedule->branch->id &&
                $this->user()->employee->branch->id == $section->branch->id
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

                foreach ($request->schedule as $type => $subject) {

                        switch ($type) {

                            case 'deleted':
                
                                $this->deletedScheduleDate($schedule->id, $section, $subject);
                                break;
                            
                            case 'updated':

                                $updatedConflict=$this->updatedScheduleDate($schedule->id, $section, $subject);
                                break;
                
                            case 'added':

                                $addedConflict=$this->addedScheduleDate($section, $subject);
                                break;
                        }
                }
                
                if (Arr::accessible($updatedConflict) || Arr::accessible($addedConflict)) {
                    
                    return response()->json([
                        'message' => "Conflict Found",
                        'results' => Arr::collapse([$updatedConflict, $addedConflict]),
                        'code'    => 409,
                        'error'   => true
                    ], 409);
                }


        } else {

            return $this->error("You're not authorized to update this schedule");
        }

        return $this->success("Schedule Successfuly Updated",
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



    private function addedScheduleDate($section, $array){

        if(!Arr::accessible($conflict=$this->hasConflict($section->branch->id, $array))){

            foreach ($array as $subject) {

                $schedule = Schedule::create([
                    "code"        => $this->classCode(),
                    "branch_id"   => $section->branch->id,
                    "section_id"  => $section->id,
                    "subject_id"  => $this->getSubjectId($subject['subject']),
                    "employee_id" => $subject['employee'] ? $this->getEmployeeId($subject['employee']) : null,
                ]);

                foreach ($subject['subjectSchedule'] as $scheduleDate) {

                    ScheduleDate::create([
                        "schedule_id" => $schedule->id,
                        "room_id"     => $this->getRoomId($scheduleDate['room']),
                        "day"         => strtoupper($scheduleDate['day']),
                        "time_start"  => $scheduleDate['timeStart'],
                        "time_end"    => Carbon::parse($scheduleDate['timeEnd'])->subMinute()
                    ]);
                }
            }

        }else{

            return $conflict;
        }
        
    }



    private function updatedScheduleDate($scheduleId, $section, $array){

        if(!Arr::accessible($conflict=$this->hasConflict($section->branch->id, $array))){

            foreach ($array as $subject) {

                Schedule::find($scheduleId)
                ->update([
                    "branch_id"   => $section->branch->id,
                    "section_id"  => $section->id,
                    "employee_id" => $subject['employee'] ? $this->getEmployeeId($subject['employee']) : null,
                ]);

                foreach ($subject['subjectSchedule'] as $scheduleDate) {

                    ScheduleDate::where('schedule_id', '=', $scheduleId)
                    ->where('room_id', '=', $this->getRoomId($scheduleDate['default']['room']))
                    ->where('day', '=', strtoupper($scheduleDate['default']['day']))
                    ->where('time_start', '=', $scheduleDate['default']['timeStart'])
                    ->where('time_end', '=', Carbon::parse($scheduleDate['default']['timeEnd'])->subMinute())
                    ->update([
                        "room_id"     => $this->getRoomId($scheduleDate['updated']['room']),
                        "day"         => strtoupper($scheduleDate['updated']['day']),
                        "time_start"  => $scheduleDate['updated']['timeStart'],
                        "time_end"    => Carbon::parse($scheduleDate['updated']['timeEnd'])->subMinute()
                    ]);
                }
            }

        }else{

            return $conflict;
        }
    }



    private function deletedScheduleDate($scheduleId, $section, $array){

        foreach ($array as $subject) {

            foreach ($subject['subjectSchedule'] as $scheduleDate) {

                ScheduleDate::where('schedule_id', '=', $scheduleId)
                ->where('room_id', '=', $this->getRoomId($scheduleDate['room']))
                ->where('day', '=', strtoupper($scheduleDate['day']))
                ->where('time_start', '=', $scheduleDate['timeStart'])
                ->where('time_end', '=', Carbon::parse($scheduleDate['timeEnd'])->subMinute())
                ->forceDelete();
            }
        }   
    }
}