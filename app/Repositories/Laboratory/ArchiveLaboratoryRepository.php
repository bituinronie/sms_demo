<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory,
    App\Models\Room\Room,
    App\Models\Subject\Subject,
    App\Models\ActivityLog\ActivityLog;

class ArchiveLaboratoryRepository extends BaseRepository
{
    public function execute($branchCode, $laboratoryCode){

        $laboratory = Laboratory::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($laboratoryCode))->firstOrFail();

        // *** Archive only if user and laboratory branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $laboratory->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            // *** Don't archive if used by other module
            $room    = Room::where('laboratory_id', '=', $laboratory->id)->get();
            $subject = Subject::where('laboratory_id', '=', $laboratory->id)->get();

            if ($room->isEmpty() || $subject->isEmpty()) {

                $laboratory->delete();

                ActivityLog::create([
                    "user_id" => $this->user()->id,
                    "action"  => "ARCHIVE",
                    "module"  => "FACILITY",
                    "message" => "ARCHIVED A LABORATORY",
                    "causeTo" => $this->activityCauseTo($laboratory, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
                ]);

            } elseif ($room->isNotEmpty()) {

                return $this->error("Can't archive because this laboratory is currently in use");
            }

        } else {

            return $this->error("You're not authorized to archive this laboratory");
        }

        return $this->success("Laboratory Successfuly Archived",
            $this->getShowData(
                $laboratory, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
	}
}