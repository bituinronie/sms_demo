<?php

namespace App\Repositories\Curriculum;

use App\Repositories\BaseRepository;

use App\Models\Curriculum\Curriculum;

class IndexCurriculumRepository extends BaseRepository
{
    public function execute() {

		// *** Show all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$curriculum = Curriculum::all();
			
		}
		// *** Show current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$curriculum = Curriculum::where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all curriculums");
			
		}

		return $this->success("List of All Curriculum", 
            $this->getIndexData(
                $curriculum,
                getForeign: [
                    'branch'     => ['code', 'name'],
                    'department' => ['code', 'name'],
                    'program'    => ['code', 'name'],
                ]
            )
        );
    }
}