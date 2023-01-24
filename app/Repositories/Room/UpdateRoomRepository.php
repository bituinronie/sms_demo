<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room,
    App\Models\Building\Building,
    App\Models\ActivityLog\ActivityLog;

class UpdateRoomRepository extends BaseRepository
{
    public function execute($request, $branchCode, $roomCode) {

        // *** Initialized building: Room and building must be same branch (used for: branch and building)
        $building = Building::where('code', '=', strtoupper($request->building))->firstOrFail();

        $room = Room::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($roomCode))->firstOrFail(); 

        // *** Initialized old data (used for: activity logs)
        $originalRoom = Room::find($room->id);
        
        // *** Update only if user, room branch and request branch (building branch) is same or if user is main branch
        if ((
                $this->user()->employee->branch->id == $room->branch->id &&
                $this->user()->employee->branch->id == $building->branch->id
            )|| $this->user()->employee->branch->type == "MAIN"
        ) {

            $room->update([
                "code"          => strtoupper($request->code),
                "name"          => strtoupper($request->name),
                "type"          => strtoupper($request->type),
                "branch_id"     => $building->branch->id,
                "laboratory_id" => $request->laboratory ? $this->getLaboratoryId($request->laboratory) : null,
                "building_id"   => $building->id,
            ]);

                // *** Initialized updated data (used for: activity logs & displaying data)
                $updatedRoom = Room::find($room->id); 

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "UPDATE",
                "module"  => "FACILITY",
                "message" => "UPDATED A ROOM",
                "causeTo" => $this->activityCauseTo($room, only: ['code', 'name'], getForeign: ['branch'=>['code', 'name']]),
                "data"    => $this->activityChangedOnly(
                    $originalRoom,
                    $updatedRoom,
                    getForeign: [
                        'laboratory' => ['code', 'name'],
                        'building'   => ['code', 'name'],
                        'branch'     => ['code', 'name']
                    ],
                    ignored   : ['branch_id', 'laboratory_id', 'building_id']
                )
            ]);

        } else {

            return $this->error("You're not authorized to update this room");

        }

        return $this->success("Room Successfuly Updated",
            $this->getShowData(
                $updatedRoom,
                getForeign: [
                    'laboratory' => ['code', 'name'],
                    'building'   => ['code', 'name'],
                    'branch'     => ['code', 'name']
                ]
            )
        );
    }
}