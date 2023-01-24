<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand;

class ListStrandRepository extends BaseRepository
{
    public function execute(){

		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$strand = Strand::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$strand = Strand::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive strand");
			
		}

		return $this->success("List of All Archive Strand", $this->getListData($strand, getForeign: ['branch'=>['code', 'name']]));
	}
}