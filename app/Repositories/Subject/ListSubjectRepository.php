<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject;

class ListSubjectRepository extends BaseRepository
{
    public function execute(){

		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$subject = Subject::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$subject = Subject::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive subject");
		}

		return $this->success("List of All Archive Subject", $this->getIndexData(
            $subject, 
            getForeign: [
                'branch'     => ['code','name'],
                'laboratory' => ['code','name'],
                'department' => ['code','name'],
            ])
        );
	}
}