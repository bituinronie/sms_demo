<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room,
    App\Models\ActivityLog\ActivityLog;

class ArchiveRoomRepository extends BaseRepository
{
    public function execute($branchCode, $roomCode){

        $room = Room::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($roomCode))->firstOrFail();

        // *** Archive only if user and room branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $room->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $room->delete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "ARCHIVE",
                "module"  => "FACILITY",
                "message" => "ARCHIVED A ROOM",
                "causeTo" => $this->activityCauseTo($room, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to archive this room");
        }

        return $this->success("Room Successfuly Archived",
            $this->getShowData(
                $room,
                getForeign: [
                    'laboratory' => ['code', 'name'],
                    'building'   => ['code', 'name'],
                    'branch'     => ['code', 'name']
                ]
            )
        );
	}
}