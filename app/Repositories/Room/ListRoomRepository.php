<?php

namespace App\Repositories\Room;

use App\Repositories\BaseRepository;

use App\Models\Room\Room;

class ListRoomRepository extends BaseRepository
{
    public function execute(){

		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$room = Room::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$room = Room::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive rooms");
			
		}			

		return $this->success("List of All Archive Room", $this->getIndexData(
			$room, 
			getForeign: [
				'branch'     => ['code', 'name'],
				'laboratory' => ['code', 'name'],
				'building'   => ['code', 'name']
			])
		);
	}
}