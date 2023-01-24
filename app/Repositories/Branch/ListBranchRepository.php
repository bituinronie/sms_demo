<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch;

class ListBranchRepository extends BaseRepository
{
    public function execute(){
			
		// *** List only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$branch = Branch::onlyTrashed()->get();

		} else {

			return $this->error("You're not authorized to view all archive branches");

		}

		return $this->success("List of All Archive Branch", $this->getListData($branch));
	}
}