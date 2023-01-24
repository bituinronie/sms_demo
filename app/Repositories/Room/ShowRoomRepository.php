<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room;

class ShowRoomRepository extends BaseRepository
{
    public function execute($branchCode, $roomCode){

            $room = Room::where('branch_id', '=', $this->getBranchId($branchCode))
            ->where('code', '=', strtoupper($roomCode))->firstOrFail();

            // *** Show only if user and room branch is same or if user is main branch
			if (
                $this->user()->employee->branch->id == $room->branch->id ||
                $this->user()->employee->branch->type == "MAIN"
            ) {

                return $this->success("Room Found", 
                    $this->getShowData(
                        $room,
                        getForeign: [
                            'laboratory' => ['code', 'name'],
                            'building'   => ['code', 'name'],
                            'branch'     => ['code', 'name']
                        ]
                    )
                );

			} else {

				return $this->error("You're not authorized to view this room");
			}
    }
}