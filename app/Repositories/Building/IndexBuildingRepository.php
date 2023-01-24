<?php

namespace App\Repositories\Building;

use App\Repositories\BaseRepository;

use App\Models\Building\Building;

class IndexBuildingRepository extends BaseRepository
{
    public function execute() {

		// *** Show all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$building = Building::all();
			
		}
		// *** Show current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$building = Building::where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all buildings");
			
		}

		return $this->success("List of All Building", $this->getIndexData($building, getForeign: ['branch'=>['code','name']]));
    }
}