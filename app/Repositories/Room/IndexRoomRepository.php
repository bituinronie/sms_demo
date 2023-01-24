<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room;

class IndexRoomRepository extends BaseRepository
{
    public function execute() {

		// *** Show all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$room = Room::all();
			
		}
		// *** Show current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$room = Room::where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all rooms");
			
		}

		return $this->success("List of All Room", $this->getIndexData(
			$room, 
			getForeign: [
				'branch'     => ['code', 'name'],
				'laboratory' => ['code', 'name'],
				'building'   => ['code', 'name']
			])
		);
    }
}