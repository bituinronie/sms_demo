<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room,
    App\Models\Building\Building,
    App\Models\ActivityLog\ActivityLog;

class CreateRoomRepository extends BaseRepository
{
    public function execute($request) {

        // *** Initialized building: Room and building must be same branch (used for: branch and building)
        $building = Building::where('code', '=', strtoupper($request->building))->firstOrFail();

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $building->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {                
            
            $room = Room::create([
                "code"          => strtoupper($request->code),
                "name"          => strtoupper($request->name),
                "type"          => strtoupper($request->type),
                "branch_id"     => $building->branch->id,
                "laboratory_id" => $request->laboratory ? $this->getLaboratoryId($request->laboratory) : null,
                "building_id"   => $building->id,
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "FACILITY",
                "message" => "CREATED A ROOM",
                "data"    => 
                [
                    "new" => [
                        "CODE"       => $room->code,
                        "NAME"       => $room->name,
                        "TYPE"       => $room->type,
                        "BRANCH"     => $room->branch->name,
                        "LABORATORY" => $room->laboratory->name ?? null,
                        "BUILDING"   => $room->building->name,
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a room");

        }

        return $this->success("Room Successfuly Created",
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