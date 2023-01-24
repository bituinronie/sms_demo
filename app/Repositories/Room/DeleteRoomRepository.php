<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room,
    App\Models\ActivityLog\ActivityLog;

class DeleteRoomRepository extends BaseRepository
{
    public function execute($branchCode, $roomCode) {

        $room = Room::onlyTrashed()
        ->where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($roomCode))->firstOrFail();
        
        // *** Delete only if user and room branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id ==  $room->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {
            
            $room->forceDelete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "DELETE",
                "module"  => "FACILITY",
                "message" => "DELETED A ROOM",
                "causeTo" => $this->activityCauseTo($room, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']])
            ]);

        } else {

            return $this->error("You're not authorized to delete this room");
        }

        return $this->success("Room Successfuly Deleted",
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