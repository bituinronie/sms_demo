<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory;

class IndexLaboratoryRepository extends BaseRepository
{
    public function execute() {

		// *** Show all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$laboratory = Laboratory::all();
			
		}
		// *** Show current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$laboratory = Laboratory::where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all laboratories");
			
		}

		return $this->success("List of All Laboratory", $this->getIndexData($laboratory, getForeign: ['branch'=>['code', 'name']]));
    }
}