<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building;

class ListBuildingRepository extends BaseRepository
{
    public function execute(){

		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$building = Building::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$building = Building::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive buildings");
			
		}

		return $this->success("List of All Archive Building", $this->getListData($building, getForeign: ['branch'=>['code','name']]));
	}
}